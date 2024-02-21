<?php

use BacByTouch\Session;

Session::sessionStart();

$title = "404 Not Found";
$css = "error.css";
$errorCode = "404";
$errorMsg = "stranica nije pronađena";

require "../app/views/partials/head.php";
require "../app/views/partials/nav.php";
require "../app/views/errorView.php";
require "../app/views/partials/footer.php";
