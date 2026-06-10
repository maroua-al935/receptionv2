using System;
using System.IO;
using System.Reflection;
using System.Threading;
using ElyctisCardService.Models;

namespace ElyctisCardService.Services
{
    public sealed class ElyctisMrzScanner
    {
        private readonly AppOptions _options;
        private readonly FileLogger _logger;

        public ElyctisMrzScanner(AppOptions options, FileLogger logger)
        {
            _options = options;
            _logger = logger;
        }

        public string ReadMrz()
        {
            if (!_options.AutoReadMrzFromScanner)
                return null;
            if (string.IsNullOrWhiteSpace(_options.ScannerPortName))
                return null;
            if (string.IsNullOrWhiteSpace(_options.ScannerAssemblyPath) || !File.Exists(_options.ScannerAssemblyPath))
            {
                _logger.Warn("Scanner assembly not found: " + _options.ScannerAssemblyPath);
                return null;
            }

            object scanner = null;
            Type scannerType = null;
            try
            {
                var assembly = Assembly.LoadFrom(_options.ScannerAssemblyPath);
                scannerType = assembly.GetType("ELY_TRAVEL_DOC.Scanner", true);
                var callback = new MrzCallback();
                var delegateType = assembly.GetType("ELY_TRAVEL_DOC.DelegateReadMrz", true);
                var callbackDelegate = Delegate.CreateDelegate(delegateType, callback, "OnMrz");
                scanner = Activator.CreateInstance(scannerType, new object[] { callbackDelegate });

                var connected = (bool)scannerType.GetMethod("Connect").Invoke(scanner, new object[] { _options.ScannerPortName });
                _logger.Info("MRZ scanner connect(" + _options.ScannerPortName + ") returned " + connected);
                if (!connected)
                    return null;

                scannerType.GetMethod("Inquire").Invoke(scanner, new object[0]);
                var mrz = callback.Wait(_options.ScannerMrzTimeoutMs);
                if (string.IsNullOrWhiteSpace(mrz))
                {
                    var readMethod = scannerType.GetMethod("ReadMRZ", BindingFlags.Instance | BindingFlags.Public | BindingFlags.NonPublic);
                    mrz = readMethod.Invoke(scanner, new object[] { _options.ScannerMrzTimeoutMs }) as string;
                }

                if (string.IsNullOrWhiteSpace(mrz))
                {
                    _logger.Info("MRZ scanner returned no data.");
                    return null;
                }

                _logger.Info("MRZ scanner returned data length " + mrz.Length);
                return mrz.Trim();
            }
            catch (Exception ex)
            {
                _logger.Warn("MRZ scanner read failed: " + Unwrap(ex).Message);
                return null;
            }
            finally
            {
                try
                {
                    if (scanner != null && scannerType != null)
                        scannerType.GetMethod("Disconnect").Invoke(scanner, new object[0]);
                }
                catch { }
            }
        }

        private static Exception Unwrap(Exception ex)
        {
            var tie = ex as TargetInvocationException;
            return tie != null && tie.InnerException != null ? tie.InnerException : ex;
        }

        private sealed class MrzCallback
        {
            private readonly ManualResetEventSlim _received = new ManualResetEventSlim(false);
            private string _mrz;

            public void OnMrz(string mrz)
            {
                _mrz = mrz;
                _received.Set();
            }

            public string Wait(int timeoutMs)
            {
                _received.Wait(timeoutMs);
                return _mrz;
            }
        }
    }
}
