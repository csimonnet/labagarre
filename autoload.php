<?php

spl_autoload_register(function($className) {
    $className = str_replace("\\", DIRECTORY_SEPARATOR, $className);
    $className = str_replace("labagarre", __DIR__.DIRECTORY_SEPARATOR, $className);
    if (file_exists($className . '.php')) {
        require $className . '.php';
    }

});