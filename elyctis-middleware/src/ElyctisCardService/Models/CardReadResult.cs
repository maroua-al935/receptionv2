namespace ElyctisCardService.Models
{
    public sealed class CardReadResult
    {
        public bool Success { get; set; }
        public string Status { get; set; }
        public string ErrorCode { get; set; }
        public string Message { get; set; }
        public string Reader { get; set; }
        public string ReadId { get; set; }
        public CardData Data { get; set; }

        public static CardReadResult NoCard(string message)
        {
            return new CardReadResult { Success = false, Status = "no_card", ErrorCode = "NO_CARD", Message = message };
        }

        public static CardReadResult Error(string code, string message)
        {
            return new CardReadResult { Success = false, Status = "error", ErrorCode = code, Message = message };
        }
    }
}
