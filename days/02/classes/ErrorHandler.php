<?php
    namespace App;

    class ErrorHandler
    {
        private $config = [];

        public function __construct($config = [])
        {
            if (is_array($config))
            {
                $this->config = array_merge($this->config, $config);
            }
        }

        /*
         * Регистрация обработчика Ошибок
         */
        public function registerErrorHandler($errorLevel = E_ALL)
        {
            set_error_handler([$this, 'error_handler'], $errorLevel);
        }

        /*
         * Регистрация обработчика Исключений
         */
        public function registerExceptionHandler()
        {
            set_exception_handler([$this, 'exception_handler']);
        }

        /*
         * Обработчик Ошибок
         */
        public function error_handler($errno , $errstr, $errfile, $errline, $errcontext)
        {
            $msg = "Ошибка ($errno) $errstr в файле $errfile в строке $errline";

            if (isset($this->config['log_errors']) && $this->config['log_errors'])
            {
                Log::error($msg);
            }

            if (isset($this->config['display_errors']) && $this->config['display_errors'])
            {
                echo $msg . PHP_EOL;
            }

            return true;
        }

        /*
         * Обработчик Исключений
         */
        public function exception_handler(\Exception $exception)
        {
            $exceptionClass = get_class($exception);
            $exceptionMessage = $exception->getMessage();
            $msg = "Исключение [$exceptionClass] $exceptionMessage";

            if (isset($this->config['log_exceptions']) && $this->config['log_exceptions'])
            {
                Log::error($msg);
            }

            if (isset($this->config['display_exceptions']) && $this->config['display_exceptions'])
            {
                echo $msg . PHP_EOL;
            }

        }
    }

?>