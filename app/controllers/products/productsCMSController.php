<?php

// include
use BacByTouch\Authenticator;
use BacByTouch\Session;
use BacByTouch\ErrorHandler;
use BacByTouch\Redirect;
use BacByTouch\Database;
use BacByTouch\Security;
use Models\Product;


require "../config/config.php";

Session::sessionStart();
Authenticator::authenticateAdmin();

$db = new Database($databaseConfig);
$posts = new Product($db->getConnection());

// searching by username
if (isset($_GET['searchName'])) {
    $filterValue = Security::sanitizeInput($_GET['searchName']);
    try {
        $filterValue = Security::validateInput($filterValue, "str");
        $rows = $posts->getFilteredProductsByName($filterValue);
    } catch (\InvalidArgumentException $e) {
        ErrorHandler::logError("Validation Error", $e->getMessage(), "userCMSController", "20");
        Redirect::redirectToErrorPage(400);
    }
    // show all
} else $rows = $posts->getAllProducts();

// view part
$title = "Products CMS";
$css = "adminCMS.css";

require "../app/views/partials/head.php";
require "../app/views/partials/adminNav.php";
require "../app/views/products/productsCMSView.php";
