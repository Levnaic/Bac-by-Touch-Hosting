<?php

use BacByTouch\Security;
use BacByTouch\ErrorHandler;
use BacByTouch\Redirect;
use BacByTouch\Session;
use BacByTouch\Authenticator;
use BacByTouch\Database;
use BacByTouch\Debug;
use Models\Post;

require "../config/config.php";

Session::sessionStart();
Authenticator::authenticateAdmin();


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['title'], $_POST['subtitle'], $_POST['body'], $_POST['imgAlt'])) {
        // sanitation of data
        $title = Security::sanitizeInput($_POST["title"]);
        $subtitle = Security::sanitizeInput($_POST["subtitle"]);
        $body = Security::sanitizeInput($_POST["body"]);
        $user_id = Security::sanitizeInput($_SESSION["user_id"]);
        $user_name = Security::sanitizeInput($_SESSION["username"]);
        $imgAlt = Security::sanitizeInput($_POST['imgAlt']);
        $id = Security::sanitizeInput($_GET["id"]);

        $img = isset($_FILES['img']) ? $_FILES['img'] : null;
        $imgPath = null;

        try {
            // validation of data
            $title = Security::validateInput($title, "txt");
            $subtitle = Security::validateInput($subtitle, "txt");
            $body = Security::validateInput($body, "txt");
            $user_id = Security::validateInput($user_id, "int");
            $user_name = Security::validateInput($user_name, "txt");
            $imgAlt = Security::validateInput($imgAlt, "txt");

            if ($img && $img['size'] > 0) {
                $imgPath = Security::validateImgUpload($img, "blog-img");
            }

            $db = new Database($databaseConfig);
            $event = new Post($db->getConnection());

            $event->updatePost($title, $subtitle, $body, $imgPath, $imgAlt, $user_id, $user_name, $id);

            header("Location: /dashboard/posts");
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
