<?php
    namespace App;

    class Autoloader
    {
        private $map = [];

        public function __construct()
        {
        }

        public function addNamespace($prefix, $path)
        {
            $prefix = trim($prefix, '\\') . '\\';
            $path = rtrim($path, '/') . '/';

            if (!isset($this->map[$prefix]))
            {
                $this->map[] = [ $prefix => [] ];
            }

            $this->map[$prefix][] = $path;

            return true;
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
            $classparts = explode('\\', trim($className, '\\'));
            $prefix = '';
            while(!empty($classparts))
            {
                $prefix .= array_shift($classparts) . '\\';
                if (isset($this->map[$prefix]))
                {
                    if ($this->loadClass($prefix, implode('/', $classparts)))
                    {
                        return true;
                    }
                }
            }

            throw new \App\Exceptions\MissingClassException("Невозможно загрузить класс: $className");
        }

        /*
         * Функция поиска файла
         */
        private function loadClass($prefix, $class)
        {
            foreach($this->map[$prefix] as $path)
            {
                $file = $path . $class . '.php';
                if (is_file($file))
                {
                    require_once($file);
                    return true;
                }
            }

            return false;
        }
    }
?>