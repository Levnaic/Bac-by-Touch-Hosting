<?php

use BacByTouch\Authenticator;
use BacByTouch\Database;
use BacByTouch\Security;
use BacByTouch\ErrorHandler;
use BacByTouch\Redirect;
use BacByTouch\Session;
use Models\Auth;

require_once "../config/config.php";

Session::sessionStart();
Authenticator::authenticateNotLoggedIn();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["email"], $_POST['username'], $_POST['password'])) {
        $email =  Security::sanitizeInput($_POST['email']);
        $username = Security::sanitizeInput($_POST['username']);
        $password = Security::sanitizeInput($_POST['password']);

        try {
            $email = Security::validateInput($email, "email");
            $username = Security::validateInput($username, "username");
            $password = Security::validateInput($password, "password");
            $userRole = "user";

            $db = new Database($databaseConfig);
            $user = new Auth($db->getConnection());

            $user->register($email, $username, $password, $userRole);

            header("Location: /login");
        } catch (\InvalidArgumentException $e) {
            ErrorHandler::logError("Validation Error", $e->getMessage(), __FILE__, __LINE__);
            Redirect::redirectToErrorPage(400);
        }
    }
}
