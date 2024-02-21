<?php

namespace BacByTouch;

use BacByTouch\ErrorHandler;
use BacByTouch\Redirect;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Mailer
{
    protected static $config;

    public function __construct()
    {
        self::$config = include(__DIR__ . "/../config/mailer-config.php");
    }

    public function sendEmail($to, $subject, $message)
    {
        $mail = new PHPMailer(true);

        try {
            $mail->SMTPDebug = 2;
            $mail->isSMTP();
            $mail->Host = self::$config["host"];
            $mail->SMTPAuth = true;
            $mail->Username = self::$config["username"];
            $mail->Password = self::$config["password"];
            $mail->SMTPSecure = self::$config["secure"];
            $mail->Port = self::$config["port"];

            // Recipients
            $mail->setFrom(self::$config["username"], "Bac by Touch");
            $mail->addAddress($to);

            // Content
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body = $message;

            $mail->send();
            return true;
        } catch (Exception $errorMessage) {
            ErrorHandler::logError("Mailer error", $errorMessage->getMessage(), __CLASS__, __LINE__);
            Redirect::redirectToErrorPage(500);
        }
    }
}

