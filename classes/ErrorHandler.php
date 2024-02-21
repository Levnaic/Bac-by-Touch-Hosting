<?php

namespace BacByTouch;

class ErrorHandler extends Redirect
{
    public static function logError($errorType, $errorMessage, $file, $line)
    {
        $logMessage = date('d-m-Y H:i:s') . ' [' . $errorType . '] ' . $errorMessage . ' in ' . $file . ' on line ' . $line . PHP_EOL;
        $logPath = dirname(__DIR__) . "/logs/error.log";

        file_put_contents($logPath, $logMessage, FILE_APPEND);
    }

    public static function displayError($errorType, $errorMessage, $file, $line)
    {
        echo '<div style="color: red; font-weight: bold;">';
        echo 'Error: ' . $errorType . '<br>';
        echo 'Message: ' . $errorMessage . '<br>';
        echo 'File: ' . $file . '<br>';
        echo 'Line: ' . $line . '<br>';
        echo '</div>';
    }
}
