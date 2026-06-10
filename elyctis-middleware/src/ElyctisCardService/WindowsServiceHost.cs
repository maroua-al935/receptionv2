using System.ServiceProcess;
using ElyctisCardService.Controllers;
using ElyctisCardService.Services;

namespace ElyctisCardService
{
    public sealed class WindowsServiceHost : ServiceBase
    {
        private readonly LocalHttpApi _api;
        private readonly FileLogger _logger;

        public WindowsServiceHost(LocalHttpApi api, FileLogger logger)
        {
            _api = api;
            _logger = logger;
            ServiceName = "ElyctisCardMiddleware";
            CanStop = true;
            AutoLog = true;
        }

        protected override void OnStart(string[] args)
        {
            _logger.Info("Windows service starting.");
            _api.Start();
        }

        protected override void OnStop()
        {
            _logger.Info("Windows service stopping.");
            _api.Stop();
        }
    }
}
