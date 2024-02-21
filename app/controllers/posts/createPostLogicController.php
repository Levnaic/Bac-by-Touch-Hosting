<?php

use BacByTouch\Security;
use BacByTouch\ErrorHandler;
use BacByTouch\Redirect;
use BacByTouch\Session;
use BacByTouch\Authenticator;
use BacByTouch\Database;
use Models\Post;

require "../config/config.php";

Session::sessionStart();
Authenticator::authenticateAdmin();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['title'], $_POST['subtitle'], $_POST['body'], $_FILES['img'])) {
        // sanitation of data
        $title = Security::sanitizeInput($_POST["title"]);
        $subtitle = Security::sanitizeInput($_POST["subtitle"]);
        $body = Security::sanitizeInput($_POST["body"]);
        $user_id = Security::sanitizeInput($_SESSION["user_id"]);
        $user_name = Security::sanitizeInput($_SESSION["username"]);
        $imgAlt = Security::sanitizeInput($_POST['imgAlt']);

        try {
            // validation of data
            $title = Security::validateInput($title, "txt");
            $subtitle = Security::validateInput($subtitle, "txt");
            $body = Security::validateInput($body, "txt");
            $user_id = Security::validateInput($user_id, "int");
            $user_name = Security::validateInput($user_name, "txt");
            $imgAlt = Security::validateInput($imgAlt, "txt");
            $imgPath = Security::validateImgUpload($_FILES['img'], "blog-img");

            $db = new Database($databaseConfig);
            $post = new Post($db->getConnection());
            $post->createNewPost($title, $subtitle, $body, $imgPath, $imgAlt, $user_id, $user_name);

            header("Location: /dashboard/posts");
            exit;
        } catch (\InvalidArgumentException $e) {
            ErrorHandler::logError("Validation Error", $e->getMessage(), "createPostLogicController", __LINE__);
            Redirect::redirectToErrorPage(400);
        }
    } else {
        ErrorHandler::logError("Missing input fields", "missing input fields in form", "createPostLogicController", __LINE__);
        Redirect::redirectToErrorPage(400);
    }
} else {
    ErrorHandler::logError("Invalid method", "Not a balid POST method", "createPostLogicController", __LINE__);
    Redirect::redirectToErrorPage(400);
}
