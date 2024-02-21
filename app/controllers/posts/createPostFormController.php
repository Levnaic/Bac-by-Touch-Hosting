<?php

use BacByTouch\Session;
use BacByTouch\Authenticator;

Session::sessionStart();
Authenticator::authenticateAdmin();

$title = "Create Post";
$css = "form.css";

require "../app/views/partials/head.php";
require "../app/views/partials/adminNav.php";
require "../app/views/posts/createPostView.php";
