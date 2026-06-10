using System;
using System.Collections.Specialized;
using System.IO;
using System.Net;
using System.Net.Sockets;
using System.Text;
using System.Threading;
using System.Threading.Tasks;
using ElyctisCardService.Models;
using ElyctisCardService.Services;

namespace ElyctisCardService.Controllers
{
    public sealed class LocalHttpApi
    {
        private readonly AppOptions _options;
        private readonly ElyctisCardReader _reader;
        private readonly FileLogger _logger;
        private TcpListener _listener;
        private CancellationTokenSource _cts;
        private Task _loop;

        public LocalHttpApi(AppOptions options, ElyctisCardReader reader, FileLogger logger)
        {
            _options = options;
            _reader = reader;
            _logger = logger;
        }

        public void Start()
        {
            var uri = new Uri(_options.ListenUrl);
            var address = IPAddress.Parse(uri.Host);
            _listener = new TcpListener(address, uri.Port);
            _listener.Start();
            _cts = new CancellationTokenSource();
            _loop = Task.Run(() => ListenAsync(_cts.Token));
        }

        public void Stop()
        {
            try
            {
                if (_cts != null)
                    _cts.Cancel();
                if (_listener != null)
                    _listener.Stop();
                if (_loop != null)
                    _loop.Wait(TimeSpan.FromSeconds(3));
            }
            catch (Exception ex)
            {
                _logger.Error("HTTP API stop failed.", ex);
            }
        }

        private async Task ListenAsync(CancellationToken token)
        {
            while (!token.IsCancellationRequested)
            {
                try
                {
                    var client = await _listener.AcceptTcpClientAsync().ConfigureAwait(false);
                    var ignored = Task.Run(() => HandleClientAsync(client), token);
                }
                catch (ObjectDisposedException)
                {
                    return;
                }
                catch (SocketException)
                {
                    if (token.IsCancellationRequested)
                        return;
                    throw;
                }
                catch (Exception ex)
                {
                    _logger.Error("HTTP listener loop failed.", ex);
                }
            }
        }

        private async Task HandleClientAsync(TcpClient client)
        {
            using (client)
            {
                var stream = client.GetStream();
                var request = await ReadRequestAsync(stream).ConfigureAwait(false);
                if (request == null)
                    return;

                if (request.Method == "OPTIONS")
                {
                    await WriteJson(stream, 204, new { }).ConfigureAwait(false);
                    return;
                }

                if (!IsAuthorized(request.Headers, request.Query))
                {
                    await WriteJson(stream, 401, new { success = false, status = "unauthorized" }).ConfigureAwait(false);
                    return;
                }

                try
                {
                    if (request.Path == "/health")
                    {
                        await WriteJson(stream, 200, new { success = true, status = "ok" }).ConfigureAwait(false);
                        return;
                    }

                    if (request.Path == "/read-card")
                    {
                        var result = await _reader.ReadCardAsync(request.Query["mrz"]).ConfigureAwait(false);
                        await WriteJson(stream, 200, result).ConfigureAwait(false);
                        return;
                    }

                    await WriteJson(stream, 404, new { success = false, status = "not_found" }).ConfigureAwait(false);
                }
                catch (Exception ex)
                {
                    _logger.Error("HTTP request failed.", ex);
                    WriteJson(stream, 500, CardReadResult.Error("HTTP_ERROR", ex.Message)).Wait();
                }
            }
        }

        private bool IsAuthorized(NameValueCollection headers, NameValueCollection query)
        {
            if (string.IsNullOrWhiteSpace(_options.ApiToken))
                return true;

            var token = headers["X-Elyctis-Token"];
            if (string.IsNullOrWhiteSpace(token))
                token = query["token"];

            return string.Equals(token, _options.ApiToken, StringComparison.Ordinal);
        }

        private async Task<RequestInfo> ReadRequestAsync(NetworkStream stream)
        {
            var buffer = new byte[8192];
            var read = await stream.ReadAsync(buffer, 0, buffer.Length).ConfigureAwait(false);
            if (read <= 0)
                return null;

            var raw = Encoding.ASCII.GetString(buffer, 0, read);
            var reader = new StringReader(raw);
            var firstLine = reader.ReadLine();
            if (string.IsNullOrWhiteSpace(firstLine))
                return null;

            var first = firstLine.Split(' ');
            if (first.Length < 2)
                return null;

            var headers = new NameValueCollection(StringComparer.OrdinalIgnoreCase);
            string line;
            while (!string.IsNullOrEmpty(line = reader.ReadLine()))
            {
                var colon = line.IndexOf(':');
                if (colon > 0)
                    headers[line.Substring(0, colon).Trim()] = line.Substring(colon + 1).Trim();
            }

            var uri = new Uri("http://127.0.0.1" + first[1]);
            return new RequestInfo
            {
                Method = first[0].ToUpperInvariant(),
                Path = uri.AbsolutePath.TrimEnd('/').ToLowerInvariant(),
                Query = ParseQuery(uri.Query),
                Headers = headers
            };
        }

        private NameValueCollection ParseQuery(string query)
        {
            var values = new NameValueCollection(StringComparer.OrdinalIgnoreCase);
            if (string.IsNullOrWhiteSpace(query))
                return values;

            foreach (var part in query.TrimStart('?').Split('&'))
            {
                if (string.IsNullOrWhiteSpace(part))
                    continue;
                var pair = part.Split(new[] { '=' }, 2);
                var key = Uri.UnescapeDataString(pair[0]);
                var value = pair.Length > 1 ? Uri.UnescapeDataString(pair[1].Replace("+", " ")) : "";
                values[key] = value;
            }

            return values;
        }

        private async Task WriteJson(NetworkStream stream, int statusCode, object body)
        {
            var json = statusCode == 204 ? "" : Json.Serialize(body);
            var payload = Encoding.UTF8.GetBytes(json);
            var reason = Reason(statusCode);
            var headers =
                "HTTP/1.1 " + statusCode + " " + reason + "\r\n" +
                "Content-Type: application/json; charset=utf-8\r\n" +
                "Content-Length: " + payload.Length + "\r\n" +
                "Access-Control-Allow-Origin: " + _options.AllowedOrigin + "\r\n" +
                "Access-Control-Allow-Methods: GET, OPTIONS\r\n" +
                "Access-Control-Allow-Headers: X-Elyctis-Token, Content-Type\r\n" +
                "Cache-Control: no-store\r\n" +
                "Connection: close\r\n\r\n";

            var headerBytes = Encoding.ASCII.GetBytes(headers);
            await stream.WriteAsync(headerBytes, 0, headerBytes.Length).ConfigureAwait(false);
            if (payload.Length > 0)
                await stream.WriteAsync(payload, 0, payload.Length).ConfigureAwait(false);
        }

        private static string Reason(int statusCode)
        {
            switch (statusCode)
            {
                case 200: return "OK";
                case 204: return "No Content";
                case 401: return "Unauthorized";
                case 404: return "Not Found";
                case 409: return "Conflict";
                default: return "Internal Server Error";
            }
        }

        private sealed class RequestInfo
        {
            public string Method { get; set; }
            public string Path { get; set; }
            public NameValueCollection Query { get; set; }
            public NameValueCollection Headers { get; set; }
        }
    }
}
