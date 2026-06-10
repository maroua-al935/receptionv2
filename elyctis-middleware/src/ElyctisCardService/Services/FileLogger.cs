using System;
using System.IO;

namespace ElyctisCardService.Services
{
    public sealed class FileLogger
    {
        private readonly object _gate = new object();
        private readonly string _directory;

        public FileLogger(string directory)
        {
            _directory = string.IsNullOrWhiteSpace(directory) ? "logs" : directory;
            Directory.CreateDirectory(_directory);
        }

        public void Info(string message) { Write("INFO", message, null); }
        public void Warn(string message) { Write("WARN", message, null); }
        public void Error(string message, Exception exception) { Write("ERROR", message, exception); }
        public void Error(string message) { Write("ERROR", message, null); }

        private void Write(string level, string message, Exception exception)
        {
            var line = string.Format("{0:O} [{1}] {2}", DateTimeOffset.Now, level, message);
            if (exception != null)
                line += Environment.NewLine + exception;

            lock (_gate)
            {
                File.AppendAllText(Path.Combine(_directory, DateTime.Today.ToString("yyyyMMdd") + ".log"), line + Environment.NewLine);
            }
        }
    }
}
