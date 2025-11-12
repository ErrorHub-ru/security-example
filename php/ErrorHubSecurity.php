<?php
/**
* Генерация секретного ключа для PHP 7.2
* Полностью совместима с версией 7.2 и выше
* Быстрая установка секретного ключа define('ERROR_HUB_DEFAULT_KEY', 'YOU_SECRET_KEY');
*/

class ErrorHubSecurity 
{
    private $secretKey;
    private $toleranceSeconds;
    
    /**
	* Конструктор класса
	* @param string $secretKey Секретный ключ (по умолчанию из константы класса)
	* @param int $toleranceSeconds Время жизни кода в секундах (по умолчанию 5 минут)
	*/
    public function __construct($secretKey = null, $toleranceSeconds = 300)
    {
        $this->secretKey = $secretKey ?: self::getDefaultSecretKey();
        $this->toleranceSeconds = $toleranceSeconds;
    }
    
    /**
	* Получить секретный ключ по умолчанию
	*/
    private static function getDefaultSecretKey()
    {
        return defined('ERROR_HUB_DEFAULT_KEY') 
            ? ERROR_HUB_DEFAULT_KEY 
            : "YOU_SECRET_KEY";
    }
    
    /**
    * Проверка валидации секретного ключа
    * @param string $receivedCode Полученный код для проверки
    * @return bool true если код валиден, false если нет
    */
    public function isValidSecretCode($receivedCode)
    {
        $currentTime = time();
        
        for ($offset = -$this->toleranceSeconds; $offset <= $this->toleranceSeconds; $offset += 30) {
            $testTimestamp = $currentTime + $offset;
            $roundedTimestamp = floor($testTimestamp / 30) * 30;
            $testCode = $this->generateCodeFromTimestamp($roundedTimestamp);
            
            if (hash_equals($testCode, $receivedCode)) {
                return true;
            }
        }
        return false;
    }
    
    /**
    * Генерация кода для текущего времени (публичный метод)
    * @return string Сгенерированный код
    */
    public function generateCurrentCode()
    {
        $currentTime = time();
        $roundedTimestamp = floor($currentTime / 30) * 30;
        return $this->generateCodeFromTimestamp($roundedTimestamp);
    }
    
    /**
    * Генерация секретного ключа на основе временной метки
    * @param int $timestamp Временная метка
    * @return string Сгенерированный хеш
    */
    public function generateCodeFromTimestamp($timestamp) {
        $data = "error-report-{$timestamp}-{$this->secretKey}";
        return hash('sha256', $data);
    }
    
    /**
    * Статический метод для быстрой генерации кода
    * @param string $secretKey Секретный ключ (опционально)
    * @return string Сгенерированный код
    */
    public static function generateCode($secretKey = null)
    {
        $instance = new self($secretKey);
        return $instance->generateCurrentCode();
    }
    
    /**
    * Статический метод для быстрой проверки кода
    * @param string $receivedCode Проверяемый код
    * @param string $secretKey Секретный ключ (опционально)
    * @return bool Результат проверки
    */
    public static function validateCode($receivedCode, $secretKey = null)
    {
        $instance = new self($secretKey);
        return $instance->isValidSecretCode($receivedCode);
    }
}
?>