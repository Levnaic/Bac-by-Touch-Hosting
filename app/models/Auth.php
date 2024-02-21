<?php

namespace Models;

use BacByTouch\Debug;
use PDO;
use PDOException;
use BacByTouch\ErrorHandler;
use BacByTouch\Redirect;

class Auth
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function login($email, $password)
    {
        try {
            $query = $this->conn->prepare("SELECT id, username, userRole, mypassword FROM users WHERE email =:email");
            $query->bindParam(":email", $email, PDO::PARAM_STR);

            $query->execute();
            $user = $query->fetch(PDO::FETCH_ASSOC);

            $query->closeCursor();

            if ($user && password_verify($password, $user['mypassword'])) {

                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['userRole'] = $user['userRole'];
                return true;
            } else {
                ErrorHandler::logError("Login Error", "Bad credentials during login", __CLASS__, __LINE__);
                return false;
            }
        } catch (PDOException $e) {
            $errorMessage = $e->getMessage();
            $sqlStatment = $query->queryString;
            ErrorHandler::logError("Database Error", $errorMessage . "|" . $sqlStatment, __CLASS__, __LINE__);
            Redirect::redirectToErrorPage(500);
        }
    }

    public function register($email, $username, $password, $userRole)
    {
        if (!$this->checkIfUserEmailExist($email)) {
            if (!$this->checkIfUsernameExist($username)) {
                try {
                    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                    $query = $this->conn->prepare("INSERT INTO users (email, username, mypassword, userRole) VALUES (:email, :username, :mypassword, :userRole)");

                    $query->bindParam(":email", $email);
                    $query->bindParam(":username", $username);
                    $query->bindParam(":mypassword", $hashedPassword);
                    $query->bindParam(":userRole", $userRole);

                    $query->execute();

                    $query->closeCursor();
                } catch (PDOException $e) {
                    $errorMessage = $e->getMessage();
                    $sqlStatment = $query->queryString;
                    ErrorHandler::logError("Database Error", $errorMessage . "|" . $sqlStatment, __CLASS__, __LINE__);
                    Redirect::redirectToErrorPage(500);
                }
            } else {
                $_SESSION["registration_error"] = "Korisničko ime: '$username' je zauzeto";
                Redirect::redirectToRegistrationPage();
            }
        } else {
            $_SESSION["registration_error"] = "Korisnički email: '$email' je zauzet";
            Redirect::redirectToRegistrationPage();
        }
    }

    protected function checkIfUserEmailExist($email)
    {
        try {
            $query = $this->conn->prepare("SELECT email FROM users WHERE email = :email");

            $query->bindParam(":email", $email, PDO::PARAM_STR);

            $query->execute();

            $result = $query->fetch(PDO::FETCH_ASSOC);

            $query->closeCursor();

            return !empty($result);
        } catch (PDOException $e) {
            $errorMessage = $e->getMessage();
            $sqlStatment = $query->queryString;
            ErrorHandler::logError("Database Error", $errorMessage . "|" . $sqlStatment, __CLASS__, __LINE__);
            Redirect::redirectToErrorPage(500);
        }
    }

    protected function checkIfUsernameExist($username)
    {
        try {
            $query = $this->conn->prepare("SELECT username FROM users WHERE username = :username");

            $query->bindParam(":username", $username, PDO::PARAM_STR);

            $query->execute();

            $result = $query->fetch(PDO::FETCH_ASSOC);

            $query->closeCursor();

            return !empty($result);
        } catch (PDOException $e) {
            $errorMessage = $e->getMessage();
            $sqlStatment = $query->queryString;
            ErrorHandler::logError("Database Error", $errorMessage . "|" . $sqlStatment, __CLASS__, __LINE__);
            Redirect::redirectToErrorPage(500);
        }
    }

    public static function logout()
    {
        session_start();
        $_SESSION = array();

        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params["path"],
                $params["domain"],
                $params["secure"],
                $params["httponly"]
            );
        }

        session_destroy();
    }



    public function deleteUser($id)
    {
        try {
            $query = $this->conn->prepare("DELETE FROM users WHERE id = :id");

            $query->bindParam(":id", $id, PDO::PARAM_INT);

            $query->execute();

            $query->closeCursor();
        } catch (PDOException $e) {
            $errorMessage = $e->getMessage();
            $sqlStatment = $query->queryString;
            ErrorHandler::logError("Database Error", $errorMessage . "|" . $sqlStatment, __CLASS__, __LINE__);
            Redirect::redirectToErrorPage(500);
        }
    }
}
