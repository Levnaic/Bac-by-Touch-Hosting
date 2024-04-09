<?php

use BacByTouch\Session;

Session::sessionStart();

$title = "Zorica Subotić";
$css = "team.css";

require "../app/views/partials/head.php";
require "../app/views/partials/nav.php";
require "../app/views/team/zoricaView.php";
require "../app/views/partials/footer.php";
