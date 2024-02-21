<?php

use BacByTouch\Session;
use BacByTouch\Database;
use BacByTouch\Security;
use Models\Producer;
use Models\Comment;

Session::sessionStart();

require "../config/config.php";

$token = Security::generateCsrfToken();

$db = new Database($databaseConfig);
$producer = new Producer($db->getConnection());
$producers = $producer->getAllProducers();

$comment = new Comment($db->getConnection());
function getCommentOfProducer($id, $comment)
{
    return $comment->getAllCommentsOfProducer($id);
}

require "../app/views/mapView.php";
