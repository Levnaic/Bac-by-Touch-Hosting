<?php

use BacByTouch\Session;

Session::sessionStart();

$title = "About us";
$css = "aboutus.css";

require "../app/views/partials/head.php";
require "../app/views/partials/nav.php";
require "../app/views/aboutusView.php";
require "../app/views/partials/footer.php";
