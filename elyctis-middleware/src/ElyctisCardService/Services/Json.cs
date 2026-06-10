using System.Web.Script.Serialization;

namespace ElyctisCardService.Services
{
    public static class Json
    {
        public static string Serialize(object value)
        {
            return new JavaScriptSerializer { MaxJsonLength = int.MaxValue }.Serialize(value);
        }
    }
}
