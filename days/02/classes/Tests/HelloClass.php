<?php
    namespace App\Tests;

    class HelloClass
    {
        public function __toString()
        {
            return 'It is HelloClass!' . PHP_EOL;
        }
    }
?>