<?php

namespace framework\interface;

interface InterfaceErrorHandler
{
    public function __construct($errorLevel);
    
    public static function init();

    public static function handleError($errno, $errstr, $errfile, $errline);

    public static function handleShutdown();

    public static function logError($message, $details = null);

    public static function handleExceptions(\Throwable $excep);
}
