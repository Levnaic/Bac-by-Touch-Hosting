<?php

use BacByTouch\Session;

Session::sessionStart();

$title = "500 Server error";
$css = "error.css";
$errorCode = "500";
$errorMsg = "serverska greška";

require "../app/views/partials/head.php";
require "../app/views/partials/nav.php";
require "../app/views/errorView.php";
require "../app/views/partials/footer.php";
