<?php

// include
use BacByTouch\Authenticator;
use BacByTouch\Session;
use BacByTouch\ErrorHandler;
use BacByTouch\Redirect;
use BacByTouch\Database;
use BacByTouch\Security;
use Models\Post;


require "../config/config.php";

Session::sessionStart();
Authenticator::authenticateAdmin();

$db = new Database($databaseConfig);
$posts = new Post($db->getConnection());

// searching by username
if (isset($_GET['searchTitle'])) {
    $filterValue = Security::sanitizeInput($_GET['searchTitle']);
    try {
        $filterValue = Security::validateInput($filterValue, "str");
        $rows = $posts->getFilteredPostsByTitle($filterValue);
    } catch (\InvalidArgumentException $e) {
        ErrorHandler::logError("Validation Error", $e->getMessage(), "userCMSController", "20");
        Redirect::redirectToErrorPage(400);
    }
    // searching by user role
} elseif (isset($_GET['searchAuthor'])) {
    $filterValue = Security::sanitizeInput($_GET['searchAuthor']);
    try {
        $filterValue = Security::validateInput($filterValue, "str");
        $rows = $posts->getFilteredPostsByAuthor($filterValue);
    } catch (\InvalidArgumentException $e) {
        ErrorHandler::logError("Validation Error", $e->getMessage(), "userCMSController", "20");
        Redirect::redirectToErrorPage(400);
    }
    // show all
} else $rows = $posts->getAllPosts();

// view part
$title = "Posts CMS";
$css = "adminCMS.css";

require "../app/views/partials/head.php";
require "../app/views/partials/adminNav.php";
require "../app/views/posts/postsCMSView.php";
