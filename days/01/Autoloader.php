<?php
    class Autoloader
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
         * Регистрация автолоадера
         */
        public function register()
        {
            spl_autoload_register([$this, 'autoload']);
        }

        /*
         * Функция автолоадера
         */
        public function autoload($className)
        {
            if (isset($this->config['classes']))
            {
                $file = $this->config['classes'] . $className . '.php';

                if (file_exists($file))
                {
                    include_once($file);
                    return ;
                }
                else {
                    throw new MissingClassException("Невозможно загрузить класс: $className");
                }
            }
        }
    }
?>