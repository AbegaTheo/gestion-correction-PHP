<?php
/**
 * Autoloader PSR-4 personnalisé
 * Cet autoloader suit la convention PSR-4 pour charger automatiquement les classes
 * en fonction de leur namespace.
 */

function loadAppClass($class) {
    $prefix = 'App\\';
    $base_dir = __DIR__ . '/src/';
    $relative_class = substr($class, strlen($prefix));
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';
    if (file_exists($file)) {
        require_once $file;
        return true;
    }
    $file_lower = $base_dir . strtolower(str_replace('\\', '/', $relative_class)) . '.php';
    if (file_exists($file_lower)) {
        require_once $file_lower;
        return true;
    }
    return false;
}

function loadConfigClass($class) {
    $prefix = 'Config\\';
    $base_dir = __DIR__ . '/config/';
    $relative_class = substr($class, strlen($prefix));
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';
    if (file_exists($file)) {
        require_once $file;
        return true;
    }
    $file_lower = $base_dir . strtolower(str_replace('\\', '/', $relative_class)) . '.php';
    if (file_exists($file_lower)) {
        require_once $file_lower;
        return true;
    }
    return false;
}

spl_autoload_register(function ($class) {
    if (strpos($class, 'App\\') === 0) {
        return loadAppClass($class);
    } elseif (strpos($class, 'Config\\') === 0) {
        return loadConfigClass($class);
    }
    return false;
});
