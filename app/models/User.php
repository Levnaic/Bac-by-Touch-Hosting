<?php

namespace Models;

use BacByTouch\Redirect;
use BacByTouch\ErrorHandler;
use PDO;
use PDOException;

class User extends ErrorHandler
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getAllUsers()
    {
        try {
            $query = $this->conn->prepare("SELECT * FROM users");

            $query->execute();
            $users = $query->fetchAll(PDO::FETCH_OBJ);

            $query->closeCursor();

            return $users;
        } catch (PDOException $e) {
            $errorMessage = $e->getMessage();
            $sqlStatment = $query->queryString;
            ErrorHandler::logError("Database Error", $errorMessage . "|" . $sqlStatment, "User", "33");
            Redirect::redirectToErrorPage(500);
        }
    }


    public function getFilteredUsersByUsername($filterValue)
    {
        try {
            $query = $this->conn->prepare("SELECT * FROM users WHERE username LIKE :filterValue");

            $filterValue = "%" . $filterValue . "%";
            $query->bindParam(":filterValue", $filterValue, PDO::PARAM_STR);

            $query->execute();
            $users = $query->fetchAll(PDO::FETCH_OBJ);

            $query->closeCursor();

            return $users;
        } catch (PDOException $e) {
            $errorMessage = $e->getMessage();
            $sqlStatment = $query->queryString;
            ErrorHandler::logError("Database Error", $errorMessage . "|" . $sqlStatment, "User", "56");
            Redirect::redirectToErrorPage(500);
        }
    }

    public function getFilteredUsersByRole($filterValue)
    {
        try {
            $query = $this->conn->prepare("SELECT * FROM users WHERE userRole LIKE :filterValue");

            $filterValue = "%" . $filterValue . "%";
            $query->bindParam(":filterValue", $filterValue, PDO::PARAM_STR);

            $query->execute();
            $users = $query->fetchAll(PDO::FETCH_OBJ);

            $query->closeCursor();

            return $users;
        } catch (PDOException $e) {
            $errorMessage = $e->getMessage();
            $sqlStatment = $query->queryString;
            ErrorHandler::logError("Database Error", $errorMessage . "|" . $sqlStatment, "User", "78");
            Redirect::redirectToErrorPage(500);
        }
    }
}
