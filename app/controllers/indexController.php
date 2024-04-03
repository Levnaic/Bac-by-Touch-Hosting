<?php


use BacByTouch\Debug;
use BacByTouch\Session;

Session::sessionStart();

$title = "Bac by Touch";
$css = "index.css";

require "../app/views/partials/head.php";
require "../app/views/partials/nav.php";
require "../app/views/indexView.php";
require "../app/views/partials/footer.php";