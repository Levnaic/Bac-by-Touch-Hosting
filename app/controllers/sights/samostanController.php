<?php

use BacByTouch\Session;

Session::sessionStart();

$title = "Samostan";
$css = "sights.css";

require "../app/views/partials/head.php";
require "../app/views/partials/nav.php";
require "../app/views/sights/samostanView.php";
require "../app/views/partials/footer.php";
