<?php

use BacByTouch\Database;
use BacByTouch\Session;
use BacByTouch\Security;
use BacByTouch\ErrorHandler;
use BacByTouch\Redirect;
use Models\Post;

require "../config/config.php";

Session::sessionStart();

$db = new Database($databaseConfig);
$post = new Post($db->getConnection());

if (isset($_GET["id"])) {
    $id = Security::sanitizeInput($_GET["id"]);

    try {
        $id = Security::validateInput($id, "int");
        $row = $post->getPostById($id);
    } catch (\InvalidArgumentException $e) {
        ErrorHandler::logError("Validation Error", $e->getMessage(), __FILE__, __LINE__);
        Redirect::redirectToErrorPage(400);
    }
} else {
    ErrorHandler::logError("missing GET parameter", "no GET parameter", __FILE__, __LINE__);
    Redirect::redirectToErrorPage(400);
}

$title = "Blog Post";
$css = "post.css";

require "../app/views/partials/head.php";
require "../app/views/partials/nav.php";
require "../app/views/posts/postView.php";
require "../app/views/partials/footer.php";
