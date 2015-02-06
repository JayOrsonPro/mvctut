<?php

    define('APPDIR', dirname(__FILE__).'/');

    include_once('Autoloader.php');

    $config = [
        'classes' => APPDIR.'classes/',
        'log_path' => APPDIR.'logs/',
        'error_level' => E_ALL & ~(E_NOTICE | E_USER_NOTICE),
        'log_errors' => true,
        'display_errors' => true,
        'log_exceptions' => true,
        'display_exceptions' => true,
    ];

    $autoloader = new Autoloader($config);
        $autoloader->register();

    $errorHandler = new ErrorHandler($config);
        $errorHandler->registerErrorHandler( isset($config['error_level']) ? $config['error_level'] : E_ALL );
        $errorHandler->registerExceptionHandler();

    echo (new HelloClass());

    // Эта ошибка обработается стандартным php-обработчиком
    trigger_error('По умолчанию эта ошибка не ловится.', E_USER_NOTICE);
    // А эта уже нашим
    trigger_error('А эта ошибка ловится!', E_USER_WARNING);

    new OopsClass();

    throw new Exception('Это исключение не обрабатывается.');
?>