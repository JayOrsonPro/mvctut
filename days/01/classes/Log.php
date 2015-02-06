<?php
    class Log
    {
        public function __construct()
        {
        }

        public static function log($message, $level = 'debug.txt')
        {
            file_put_contents(APPDIR.'logs/'.$level, $message . PHP_EOL, FILE_APPEND);
        }

        public static function error($message)
        {
            static::log($message, 'error.txt');
        }
    }
?>