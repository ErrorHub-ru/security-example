using System;
using System.Collections.Generic;
using System.Net.Http;
using System.Text;
using System.Threading.Tasks;
using _ERRORHUB__ErrorReporting;

namespace MyApp
{
    class Program
    {
        static void Main()
        {
            string code = ErrorReporter.GenerateSecretCode();
			Console.WriteLine(code);
        }
    }
}