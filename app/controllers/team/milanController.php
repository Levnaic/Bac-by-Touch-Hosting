<?php

use BacByTouch\Session;

Session::sessionStart();

$title = "Milan Končar";
$css = "team.css";

require "../app/views/partials/head.php";
require "../app/views/partials/nav.php";
require "../app/views/team/milanView.php";
require "../app/views/partials/footer.php";
