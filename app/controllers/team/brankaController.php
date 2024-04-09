<?php

use BacByTouch\Session;

Session::sessionStart();

$title = "Branka Mandić";
$css = "team.css";

require "../app/views/partials/head.php";
require "../app/views/partials/nav.php";
require "../app/views/team/brankaView.php";
require "../app/views/partials/footer.php";
