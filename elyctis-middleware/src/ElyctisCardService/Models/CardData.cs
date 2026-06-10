namespace ElyctisCardService.Models
{
    public sealed class CardData
    {
        public string FirstName { get; set; }
        public string LastName { get; set; }
        public string FullName { get; set; }
        public string DocumentNumber { get; set; }
        public string NationalIdentificationNumber { get; set; }
        public string DocumentType { get; set; }
        public string Nationality { get; set; }
        public string NationalityIso { get; set; }
        public string DateOfBirth { get; set; }
        public string Gender { get; set; }
        public string ExpiryDate { get; set; }
        public string IssuingCountry { get; set; }
        public string IssuingAuthority { get; set; }
        public string Mrz { get; set; }
        public string PhotoBase64 { get; set; }
        public string PhotoMimeType { get; set; }
    }
}
