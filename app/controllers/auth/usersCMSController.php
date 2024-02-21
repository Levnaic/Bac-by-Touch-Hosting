<?php

// include
use BacByTouch\Authenticator;
use BacByTouch\Session;
use BacByTouch\ErrorHandler;
use BacByTouch\Redirect;
use BacByTouch\Database;
use BacByTouch\Security;
use Models\User;


require "../config/config.php";

Session::sessionStart();
Authenticator::authenticateAdmin();

$db = new Database($databaseConfig);
$users = new User($db->getConnection());

// searching by username
if (isset($_GET['searchUsername'])) {
    $filterValue = Security::sanitizeInput($_GET['searchUsername']);
    try {
        $filterValue = Security::validateInput($filterValue, "str");
        $rows = $users->getFilteredUsersByUsername($filterValue);
    } catch (\InvalidArgumentException $e) {
        ErrorHandler::logError("Validation Error", $e->getMessage(), __FILE__, __LINE__);
        Redirect::redirectToErrorPage(400);
    }
    // searching by user role
} elseif (isset($_GET['searchUserRole'])) {
    $filterValue = Security::sanitizeInput($_GET['searchUserRole']);
    try {
        $filterValue = Security::validateInput($filterValue, "str");
        $rows = $users->getFilteredUsersByRole($filterValue);
    } catch (\InvalidArgumentException $e) {
        ErrorHandler::logError("Validation Error", $e->getMessage(), __FILE__, __LINE__);
        Redirect::redirectToErrorPage(400);
    }
    // show all
} else $rows = $users->getAllUsers();

// view part
$title = "Users CMS";
$css = "adminCMS.css";

require "../app/views/partials/head.php";
require "../app/views/partials/adminNav.php";
require "../app/views/auth/usersCMSView.php";
