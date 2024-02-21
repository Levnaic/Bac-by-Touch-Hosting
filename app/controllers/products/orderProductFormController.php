<?php

use BacByTouch\Session;
use BacByTouch\Authenticator;
use BacByTouch\Database;
use BacByTouch\ErrorHandler;
use BacByTouch\Redirect;
use BacByTouch\Security;
use Models\Product;

require_once "../config/config.php";

Session::sessionStart();
Authenticator::authenticateUserOrAdmin();

if (isset($_GET["id"])) {
    $id = Security::sanitizeInput($_GET["id"]);
    try {
        $id = Security::validateInput($id, "int");

        $db = new Database($databaseConfig);
        $products = new Product($db->getConnection());

        $rows = $products->getProductsOfProducer($id);
    } catch (\InvalidArgumentException $e) {
        ErrorHandler::logError("Validation Error", $e->getMessage(), __FILE__, __LINE__);
        Redirect::redirectToErrorPage(400);
    }
}

$csrfToken = Security::generateCsrfToken();

$title = "Order Product";
$css = "form.css";

require "../app/views/partials/head.php";
require "../app/views/products/orderProductView.php";
