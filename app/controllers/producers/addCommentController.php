<?php

use BacByTouch\Session;
use BacByTouch\Security;
use BacByTouch\Database;
use BacByTouch\Authenticator;
use Models\Comment;

require "../config/config.php";

Session::sessionStart();
Authenticator::authenticateUserOrAdmin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['csrf_token']) && Security::validateCsrfToken($_POST['csrf_token'])) {
        if (isset($_POST['marker_id'], $_POST['comment'], $_POST['rate'])) {

            $markerID = Security::sanitizeInput($_POST['marker_id']);
            $markerID = Security::validateInput($markerID, "int");

            $commentTxt = Security::sanitizeInput($_POST['comment']);
            $commentTxt = Security::validateInput($commentTxt, "txt");

            $rating = Security::sanitizeInput($_POST['rate']);
            $rating = Security::validateInput($rating, "int");

            $username = Security::sanitizeInput($_SESSION['username']);
            $username = Security::validateInput($username, "username");

            $db = new Database($databaseConfig);
            $comment = new Comment($db->getConnection());
            $comment->addComment($markerID, $commentTxt, $rating, $username);
        } else {
            echo "Missing input fields";
        }
    } else {
        echo "CSRF token not valid";
    }
}
header("location: /map");
