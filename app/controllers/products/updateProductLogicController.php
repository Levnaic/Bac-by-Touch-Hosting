<?php

use BacByTouch\Security;
use BacByTouch\ErrorHandler;
use BacByTouch\Redirect;
use BacByTouch\Session;
use BacByTouch\Authenticator;
use BacByTouch\Database;
use BacByTouch\Debug;
use Models\Product;

require "../config/config.php";

Session::sessionStart();
Authenticator::authenticateAdmin();


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['productName'], $_POST['productProducer'], $_POST['productPrice'], $_POST['productInStock'], $_GET['id'])) {
        // sanitation of data
        $name = Security::sanitizeInput($_POST["productName"]);
        $producer = Security::sanitizeInput($_POST["productProducer"]);
        $price = Security::sanitizeInput($_POST["productPrice"]);
        $inStock = Security::sanitizeInput($_POST["productInStock"]);
        $id = Security::sanitizeInput($_GET["id"]);

        try {
            // validation of data
            $name = Security::validateInput($name, "txt");
            $producer = Security::validateInput($producer, "int");
            $price = Security::validateInput($price, "int");
            $inStock = Security::validateInput($inStock, "int");
            $id = Security::validateInput($id, "int");

            $db = new Database($databaseConfig);
            $product = new Product($db->getConnection());

            $product->updateProduct($name, $producer, $price, $inStock, $id);

            header("Location: /dashboard/products");
            exit;
        } catch (\InvalidArgumentException $e) {
            ErrorHandler::logError("Validation Error", $e->getMessage(), __FILE__, __LINE__);
            Redirect::redirectToErrorPage(400);
        }
    } else {
        ErrorHandler::logError("Missing input fields", "missing input fields in form", __FILE__, __LINE__);
        Redirect::redirectToErrorPage(400);
    }
} else {
    ErrorHandler::logError("Invalid method", "Not a balid POST method", __FILE__, __LINE__);
    Redirect::redirectToErrorPage(400);
}
