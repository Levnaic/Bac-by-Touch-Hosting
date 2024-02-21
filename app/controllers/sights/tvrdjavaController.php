<?php

use BacByTouch\Session;

Session::sessionStart();

$title = "Tvrđava";
$css = "sights.css";

require "../app/views/partials/head.php";
require "../app/views/partials/nav.php";
require "../app/views/sights/tvrdjavaView.php";
require "../app/views/partials/footer.php";
