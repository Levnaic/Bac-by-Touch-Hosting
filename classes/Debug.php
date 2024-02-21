<?php

namespace BacByTouch;

class Debug
{
    public static function dd($value)
    {
        echo "<pre>";
        var_dump($value);
        echo "</pre>";
        die();
    }

    public static function log($message)
    {
        $logPath = dirname(__DIR__) . "/logs/debug.log";

        $timestamp = date("d-m-Y H:i:s");
        $logMessage = "[$timestamp] $message" . PHP_EOL;

        file_put_contents($logPath, $logMessage, FILE_APPEND);
    }

    public static function handleErrors()
    {
        set_error_handler(function ($errno, $errstr, $errfile, $errline) {
        });
    }
}
