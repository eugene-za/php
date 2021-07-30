<?php

/**
 * Register autoloader function
 */

spl_autoload_register(function ($class_name) {

    $file_name = APP_DIR . str_replace('\\', '/', $class_name) . '.php';
    
    if (file_exists($file_name)) {
        include $file_name;
    }

});