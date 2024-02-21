<?php

use BacByTouch\Session;

Session::sessionStart();

$title = "Manastir";
$css = "sights.css";

require "../app/views/partials/head.php";
require "../app/views/partials/nav.php";
require "../app/views/sights/manastirView.php";
require "../app/views/partials/footer.php";
