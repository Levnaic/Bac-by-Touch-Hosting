<?php 

namespace Models;

use PDOException;
use BacByTouch\ErrorHandler;
use BacByTouch\Redirect;

class BaseModel
{
    protected $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    protected function executeQuery($query, $bindings = [])
    {
       
    }
}