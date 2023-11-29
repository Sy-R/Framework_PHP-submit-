<?php

namespace app\controllers;

use framework\abstract\AbstractErrorHandler;

class ErrorHandler extends AbstractErrorHandler
{
    protected static $enabled = true;
    protected static $errorReportingLevel;
    protected static $logToFile = true;
    protected static $logFileName = 'error.log';

    
    public static function handleError($errno, $errstr, $errfile, $errline)
    {
        if (!(error_reporting() & $errno)) {
            return false;
        }

        self::logError("PHP Error [$errno]: $errstr in $errfile on line $errline");
        echo "PHP Error [$errno]: $errstr in $errfile on line $errline" . "<br/>" . "<br/>";
        return true;
    }


    public static function logError($message, $details = null)
    {
        if (self::$logToFile) {
            if (is_array($details)) {
                // If $details is an array, serialize it into a string
                $details = json_encode($details, JSON_PRETTY_PRINT);
            }

            $logMessage = $message . PHP_EOL . $details . PHP_EOL;

            if (!file_put_contents(self::$logFileName, $logMessage, FILE_APPEND)) {
                // Log file write failure, handle as needed
                error_log('Failed to write to the log file', 0);
            }
        }
    }

    public static function handleExceptions(\Throwable $excep)
    {
        $errorMsg = 'An exception occurred: ' . $excep->getMessage();
        $errorDetails = [
            'Exception Class' => get_class($excep),
            'File' => $excep->getFile(),
            'Line' => $excep->getLine(),
            'Stack Trace' => $excep->getTraceAsString(),
        ];

        // Log full details of the exception
        self::logError($errorMsg, $errorDetails);

        // Echo/return a user-friendly message to the output
        // echo $errorMsg;
        return $errorMsg;
    }
}

