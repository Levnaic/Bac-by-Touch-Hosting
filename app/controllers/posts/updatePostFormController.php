<?php

use BacByTouch\Session;
use BacByTouch\Authenticator;
use BacByTouch\Database;
use BacByTouch\Debug;
use BacByTouch\ErrorHandler;
use BacByTouch\Redirect;
use BacByTouch\Security;
use Models\Post;

require "../config/config.php";


Session::sessionStart();
Authenticator::authenticateAdmin();

if (isset($_GET["id"])) {

    $id = Security::sanitizeInput($_GET["id"]);
    try {
        $id = Security::validateInput($id, "int");

        $db = new Database($databaseConfig);
        $post = new Post($db->getConnection());

        $row =  $post->getPostById($id);
    } catch (\InvalidArgumentException $e) {
        ErrorHandler::logError("Validation Error", $e->getMessage(), __FILE__, __LINE__);
        Redirect::redirectToErrorPage(400);
    }
}

$title = "Update Post";
$css = "form.css";

require "../app/views/partials/head.php";
require "../app/views/partials/adminNav.php";
require "../app/views/posts/updatePostView.php";
