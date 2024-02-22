<?php

namespace BacByTouch;

use BacByTouch\ErrorHandler;
use BacByTouch\Debug;

Security::initialize();

class Security
{

    //loading configuration files
    protected static $configSecurity;
    protected static $configPaths;

    static function initialize()
    {
        self::$configSecurity = include(__DIR__ . "/../config/sec-config.php");

        if (getenv('ENVIRONMENT') === 'local') {
            self::$configPaths = include(__DIR__ . "/../config/paths-config-local.php");
        } elseif (getenv('ENVIRONMENT') === 'production') {
            self::$configPaths = include(__DIR__ . "/../config/paths-config.php");
        } else {
            ErrorHandler::logError("Pathing error:", "evniroment not set in .env file", __CLASS__, __LINE__);
            Redirect::redirectToErrorPage(500);
        }
    }

    static function isLocalEnvironment()
    {
        return ($_SERVER['SERVER_ADDR'] ===  '127.0.0.1');
    }

    public static function sanitizeInput($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);

        return $data;
    }

    public static function validateInput($data, $type, $customPattern = null)
    {
        try {
            if ($data === '' || $data === null) {
                throw new \InvalidArgumentException("No input.");
            }

            switch ($type) {
                case 'str':
                    $pattern = self::$configSecurity['regexStrPattern'];
                    $errorMessage = 'Invalid string format';
                    break;

                case 'int':
                    $pattern = self::$configSecurity['regexIntPattern'];
                    $errorMessage = 'Invalid integer format';
                    break;

                case 'email':
                    $pattern = self::$configSecurity['regexEmailPattern'];
                    $errorMessage = 'Invalid email format';
                    break;

                case 'txt':
                    $pattern = self::$configSecurity['regexTxtPattern'];
                    $errorMessage = 'Invalid text format';
                    break;

                    //username is 1-20 characters long, no _ or . at the beginning, no __ or _. or ._ or .. inside, no _ or . at the end
                    // /^(?=.{1,20}$)(?![_.])(?!.*[_.]{2})[a-zA-Z0-9._]+(?<![_.])$/
                case 'username':
                    $pattern = self::$configSecurity['regexUsernamePattern'];
                    $errorMessage = "Invalid username format";
                    break;

                case 'date':
                    $pattern = self::$configSecurity['regexDatePattern'];
                    $errorMessage = "Invalid date format";
                    break;

                case 'float':
                    $pattern = self::$configSecurity['regexFloatPattern'];
                    $errorMessage = "Invalid float format";
                    break;

                case 'password':
                    // !PRODUKCIJA promeniti ovo
                    // $pattern = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d@$!%*#?&]{8,}$/";
                    $pattern = self::$configSecurity['regexPasswordPattern'];
                    $errorMessage = "Invalid password format";
                    break;

                case 'imgFileName':
                    $pattern = self::$configSecurity['regexImgFileNamePattern'];
                    $errorMessage = "Invalid img file name";
                    break;

                case 'phone':
                    $pattern = self::$configSecurity['regexPhoneNumberPattern'];
                    $errorMessage = "Invalid phone number pattern";
                    break;

                default:
                    $pattern = $customPattern;
                    $errorMessage = 'Invalid format';
            }

            if (!preg_match($pattern, $data)) {
                throw new \InvalidArgumentException($errorMessage);
            }

            return $data;
        } catch (\InvalidArgumentException $e) {
            ErrorHandler::logError("Validation error:", $e->getMessage(), __CLASS__, __LINE__);
            Redirect::redirectToErrorPage(400);
        }
    }

    public static function validateImgUpload($file, $uploadDir)
    {
        $fileType = mime_content_type($file['tmp_name']);

        if (!in_array($fileType, self::$configSecurity['allowedImageTypes'])) {
            ErrorHandler::logError("Invalid File Type", "Invalid file type detected", __CLASS__, __LINE__);
            Redirect::redirectToErrorPage(400);
        }

        if ($file['size'] > self::$configSecurity['maxFileSize']) {
            // File size exceeds limit
            ErrorHandler::logError("File Size Exceeded", "File size exceeds the allowed limit", __CLASS__, __LINE__);
            Redirect::redirectToErrorPage(400);
        }


        $randomFileName = uniqid() . '_' . $file['name'];

        $uploadRoot = self::$configPaths['imgUploadPath'];
        $uploadPath = $uploadRoot . $uploadDir . DIRECTORY_SEPARATOR . basename($randomFileName);

        // Debug::dd($uploadPath);
        // Debug::dd(getcwd());

        if (!move_uploaded_file($file['tmp_name'], $uploadPath)) {
            // File upload failed
            ErrorHandler::logError("File Upload Failed", "Error moving uploaded file", __CLASS__, __LINE__);
            Redirect::redirectToErrorPage(500);
        }

        //!PRODUKCIJA ovo ce u neki config ici
        // Set appropriate directory permissions
        chmod($uploadPath, 0644);
        return $randomFileName;
    }

    public static function generateCsrfToken()
    {
        $token = bin2hex(random_bytes(32));
        $_SESSION['csrf_token'] = $token;
        return $token;
    }

    public static function validateCsrfToken($token)
    {
        return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
    }
}
