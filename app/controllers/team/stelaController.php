<?php

use BacByTouch\Session;

Session::sessionStart();

$title = "Stela Badivuk";
$css = "team.css";

require "../app/views/partials/head.php";
require "../app/views/partials/nav.php";
require "../app/views/team/stelaView.php";
require "../app/views/partials/footer.php";
