<?php
/**
 * PHPMailer SPL autoloader.
 * @param string $class The name of the class to load
 */
function PHPMailerAutoload($class) {
    // Can't use __DIR__ because older PHP versions don't support it
    $filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'class.' . strtolower($class) . '.php';
    if (is_readable($filename)) {
        require $filename;
    }
}

spl_autoload_register('PHPMailerAutoload');
