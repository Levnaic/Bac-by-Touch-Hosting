<?php

use BacByTouch\Session;
use BacByTouch\Authenticator;
use BacByTouch\Database;
use BacByTouch\Debug;
use BacByTouch\ErrorHandler;
use BacByTouch\Redirect;
use BacByTouch\Security;
use Models\Producer;
use Models\Product;

require "../config/config.php";


Session::sessionStart();
Authenticator::authenticateAdmin();

if (isset($_GET["id"])) {

    $id = Security::sanitizeInput($_GET["id"]);
    try {
        $id = Security::validateInput($id, "int");

        $db = new Database($databaseConfig);
        $producer = new Product($db->getConnection());

        $row =  $producer->getProductById($id);

        $producers = new Producer($db->getConnection());

        $rowsProducers = $producers->getProducersNamesAndId();
    } catch (\InvalidArgumentException $e) {
        ErrorHandler::logError("Validation Error", $e->getMessage(), __FILE__, __LINE__);
        Redirect::redirectToErrorPage(400);
    }
}

$title = "Update Producer";
$css = "form.css";

require "../app/views/partials/head.php";
require "../app/views/partials/adminNav.php";
require "../app/views/products/updateProductView.php";
