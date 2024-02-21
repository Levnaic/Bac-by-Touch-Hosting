<?php

use BacByTouch\Session;

Session::sessionStart();

$title = "Šiljak";
$css = "sights.css";

require "../app/views/partials/head.php";
require "../app/views/partials/nav.php";
require "../app/views/sights/siljakView.php";
require "../app/views/partials/footer.php";
