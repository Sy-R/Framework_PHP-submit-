<?php

namespace framework\abstract;

use framework\interface\InterfaceErrorHandler;

abstract class AbstractErrorHandler implements InterfaceErrorHandler
{
    protected static $enabled = true;
    protected static $errorReportingLevel;
    protected static $logToFile = true;
    protected static $logFileName = 'error.log';

    public function __construct($errorLevel)
    {
        if (!is_int($errorLevel) || ($errorLevel & ~E_ALL) !== 0) {
            throw new \InvalidArgumentException('Invalid error reporting level provided');
        }

        self::$errorReportingLevel = $errorLevel;

        if (self::$logToFile && !is_writable(self::$logFileName)) {
            throw new \RuntimeException('Log file is not writable');
        }

        set_error_handler([$this, 'handleError'], self::$errorReportingLevel);
        set_exception_handler([$this, 'handleExceptions']); 

        // Register the shutdown function to handle errors that occur during script execution
        register_shutdown_function([__CLASS__, 'handleShutdown']);
    }

    public static function init()
    {
        if (self::$enabled) {
            error_reporting(self::$errorReportingLevel);
            set_error_handler([__CLASS__, 'handleError']);
            set_exception_handler([__CLASS__, 'handleExceptions']); 
        }
    }

    public static function handleShutdown()
    {
        $error = error_get_last();

        if ($error && (error_reporting() & $error['type'])) {
            self::logError("Fatal Error: {$error['message']} in {$error['file']} on line {$error['line']}");
        }

        // Restore the original error handler
        restore_error_handler();
    }

    abstract public static function handleError($errno, $errstr, $errfile, $errline);

    abstract public static function logError($message, $details = null);

    abstract public static function handleExceptions(\Throwable $excep);
}
