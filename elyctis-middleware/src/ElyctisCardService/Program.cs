using System;
using System.IO;
using System.ServiceProcess;
using System.Threading;
using ElyctisCardService.Controllers;
using ElyctisCardService.Models;
using ElyctisCardService.Services;

namespace ElyctisCardService
{
    internal static class Program
    {
        private static void Main(string[] args)
        {
            Directory.SetCurrentDirectory(AppDomain.CurrentDomain.BaseDirectory);

            var options = AppOptions.Load("appsettings.json");
            var logger = new FileLogger(options.LogDirectory);
            var scanner = new ElyctisMrzScanner(options, logger);
            var reader = new ElyctisCardReader(options, logger, scanner);
            var api = new LocalHttpApi(options, reader, logger);

            if (HasArg(args, "--headless"))
            {
                api.Start();
                logger.Info("Elyctis middleware running in headless mode on " + options.ListenUrl);
                WaitHandle.WaitAny(new[] { new ManualResetEvent(false) });
                return;
            }

            if (Environment.UserInteractive || HasArg(args, "--console"))
            {
                api.Start();
                logger.Info("Elyctis middleware running in console mode on " + options.ListenUrl);
                Console.WriteLine("Elyctis middleware running on " + options.ListenUrl);
                Console.WriteLine("Press ENTER to stop.");
                Console.ReadLine();
                api.Stop();
                return;
            }

            ServiceBase.Run(new WindowsServiceHost(api, logger));
        }

        private static bool HasArg(string[] args, string value)
        {
            foreach (var arg in args)
            {
                if (string.Equals(arg, value, StringComparison.OrdinalIgnoreCase))
                    return true;
            }

            return false;
        }
    }
}
