<?php

use BacByTouch\Database;
use BacByTouch\Security;
use BacByTouch\ErrorHandler;
use BacByTouch\Redirect;
use Models\Product;

require_once "../config/config.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_GET["id"])) {
        $id = Security::sanitizeInput($_GET["id"]);
        try {
            $id = Security::validateInput($id, "int");

            $db = new Database($databaseConfig);
            $producer = new Product($db->getConnection());

            $producer->deleteProduct($id);
        } catch (\InvalidArgumentException $e) {
            ErrorHandler::logError("Validation Error", $e->getMessage(), __FILE__, __LINE__);
            Redirect::redirectToErrorPage(400);
        }

        header("location: /dashboard/products");
    } else {
        ErrorHandler::logError("Missing input", "All input fields are not set", __FILE__, __LINE__);
        Redirect::redirectToErrorPage(400);
    }
} else {
    ErrorHandler::logError("Bad Method", "Server Request Method is not POST", __FILE__, __LINE__);
    Redirect::redirectToErrorPage(400);
}
