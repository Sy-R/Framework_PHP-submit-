<?php
spl_autoload_register('myAutoloader');

function myAutoloader($className)
{

    // Define the base directories for each namespace
    $namespaceDirectories = [
        'web' => '/wamp64/www/web/',
        // 'web'=> '/xampp/htdocs/web/'
    ];

    // Convert namespace seperators to directory separators
    $classPath = str_replace('\\', DIRECTORY_SEPARATOR, $className);
    $classPath = $className . '.php';

    // Check if the class belongs to one of the specified namespaces
    foreach ($namespaceDirectories as $namespace => $directory) {
        if (strpos($className, $namespace) === 0) {
            $filePath = $directory . substr($classPath, strlen($namespace) + 1);
            if (file_exists($filePath)) {
                require_once $filePath;
                return;
            }
        }
    }

    // If the class doesn't belong to any specified namespace, construct the file path using the base directory
    $filePath = dirname(__DIR__) . DIRECTORY_SEPARATOR . $classPath;
    if (file_exists($filePath)) {
        require_once $filePath;
        return;
    }

    throw new \Exception("Autoloader Error: Class {$className} not found. File: {$filePath}");
}