using System;
using System.Collections.Generic;
using System.Net.Http;
using System.Text;
using System.Threading.Tasks;

namespace _ERRORHUB__ErrorReporting
{
	internal class ErrorReporter
	{
		/**
		* Ваш секретный ключ
		*/
		
		private static readonly string ERROR_HUB_KEY = "YOU_SECRET_KEY";
		
		/**
		* Генерация кода для текущего времени (публичный метод)
		* @return string Сгенерированный код
		*/
		
		public static string GenerateSecretCode()
		{
			long timestamp = DateTimeOffset.UtcNow.ToUnixTimeSeconds();
			long roundedTimestamp = (long)(Math.Floor(timestamp / 30.0) * 30);

			using (var sha256 = System.Security.Cryptography.SHA256.Create())
			{
				string data = $"error-report-{roundedTimestamp}-{ERROR_HUB_KEY}";
				byte[] bytes = sha256.ComputeHash(Encoding.UTF8.GetBytes(data));
				return BitConverter.ToString(bytes).Replace("-", "").ToLower();
			}
		}
	}
}