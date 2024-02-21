<?php

use BacByTouch\Authenticator;
use BacByTouch\Database;
use BacByTouch\Session;
use BacByTouch\ErrorHandler;
use BacByTouch\Redirect;
use BacByTouch\Security;
use Models\Auth;

require "../config/config.php";

Session::sessionStart();
Authenticator::authenticateNotLoggedIn();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['email'], $_POST['password'])) {

        $db = new Database($databaseConfig);
        $auth = new Auth($db->getConnection());

        $email = Security::sanitizeInput($_POST['email']);
        $password = Security::sanitizeInput($_POST['password']);

        try {
            Security::validateInput($email, "email");
            Security::validateInput($password, "password");

            if ($auth->login($email, $password)) {
                header("Location: /");
                exit;
            } else {
                $_SESSION["loginFailed"] = 1;
                header("Location: /login");
            }
        } catch (\InvalidArgumentException $e) {
            ErrorHandler::logError("Validation Error", $e->getMessage(), __FILE__, __LINE__);
            Redirect::redirectToErrorPage(400);
        }
    } else {
        ErrorHandler::logError("Missing input", "All input fields are not set", __FILE__, __LINE__);
        Redirect::redirectToErrorPage(400);
    }
} else {
    ErrorHandler::logError("Bad Method", "Server Request Method is not POST", __FILE__, __LINE__);
    Redirect::redirectToErrorPage(400);
}
