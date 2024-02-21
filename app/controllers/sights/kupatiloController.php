<?php

use BacByTouch\Session;

Session::sessionStart();

$title = "Tursko kupatilo";
$css = "sights.css";

require "../app/views/partials/head.php";
require "../app/views/partials/nav.php";
require "../app/views/sights/kupatiloView.php";
require "../app/views/partials/footer.php";
