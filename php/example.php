<?
	// Объявляем свой секретный ключ, инициализируем библиотеку
	define('ERROR_HUB_DEFAULT_KEY', 'YOU_SECRET_KEY');
	require_once 'ErrorHubSecurity.php';

	// Создание экземпляра класса
	$security = new ErrorHubSecurity();

	// Генерация кода
	$code = $security->generateCurrentCode();
	echo "Сгенерированный код: ". $code;

	// Проверка кода
	if ($security->isValidSecretCode($code)) {
		echo "<br>Код верный!";
	} else {
		echo "<br>Неверный код!";
	}
	
	// Быстрая генерация секретного кода, используя какой-либо другой ключ
	$code = ErrorHubSecurity::generateCode("_YOU_SECRET_KEY");
	echo '<br>Быстрая генерация с другим ключем: '. $code;
	
	// Быстрая генерация проверка кода, используя какой-либо другой ключ
	$isValid = ErrorHubSecurity::validateCode($code, "_YOU_SECRET_KEY");
	
	// Проверка кода
	if ($isValid) {
		echo "<br>Код верный!";
	} else {
		echo "<br>Неверный код!";
	}
	
	// Быстрая генерация секретного кода, используя уже объявленный ключ define('ERROR_HUB_DEFAULT_KEY', 'YOU_SECRET_KEY');
	$code = ErrorHubSecurity::generateCode();
	echo '<br>Быстрая генерация без ключа: '. $code;
	
	// Быстрая генерация проверка кода, используя уже объявленный ключ define('ERROR_HUB_DEFAULT_KEY', 'YOU_SECRET_KEY');
	$isValid = ErrorHubSecurity::validateCode($code);
	
	// Проверка кода
	if ($isValid) {
		echo "<br>Код верный!";
	} else {
		echo "<br>Неверный код!";
	}