<?php

require "../config/config.php";

use BacByTouch\Session;
use BacByTouch\Database;
use BacByTouch\Security;
use Models\Post;

Session::sessionStart();

$db = new Database($databaseConfig);

$post = new Post($db->getConnection());
$posts = $post->getAllPosts();
$posts = array_reverse($posts);

$title = "Blog";
$css = "blog.css";

require "../app/views/partials/head.php";
require "../app/views/partials/nav.php";
require "../app/views/blogView.php";
require "../app/views/partials/footer.php";