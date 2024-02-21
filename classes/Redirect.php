<?php

namespace BacByTouch;

class Redirect
{
    public static function redirectToHome()
    {
        header("Location: /");
        exit;
    }

    public static function redirectToErrorPage($errorCode = 404)
    {
        http_response_code($errorCode);

        if (file_exists(dirname(__DIR__) . "/app/controllers/error/$errorCode.php")) {
            //!PRODUKCIJA izbaciti liniju ispod
            // Debug::dd("greska u ruteru " . $_SERVER['REQUEST_URI']);
            header("Location: /error$errorCode");
            exit;
        } else {
            die("Error $errorCode");
        }
    }

    public static function redirectToRegistrationPage()
    {
        header("Location: /register");
        exit;
    }
}
