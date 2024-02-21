<?php

namespace BacByTouch;

use PDO;
use PDOException;
use BacByTouch\ErrorHandler;

class Database
{
    private $conn;

    public function __construct($config)
    {
        try {
            $host = $config["host"];
            $dbname = $config["dbname"];
            $user = $config["user"];
            $pass = $config["pass"];

            $this->conn = new PDO("mysql:host={$host};dbname={$dbname}", $user, $pass);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            ErrorHandler::logError("Falied to connect to database", $e->getMessage(), "Database", "22");
            Redirect::redirectToErrorPage(500);
        }
    }

    public function getConnection()
    {
        return $this->conn;
    }
}
