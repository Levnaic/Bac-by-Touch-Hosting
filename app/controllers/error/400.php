<?php

use BacByTouch\Session;

Session::sessionStart();

$title = "400 Bad Request response";
$css = "error.css";
$errorCode = "400";
$errorMsg = "Loš odgovor na zahtev";

require "../app/views/partials/head.php";
require "../app/views/partials/nav.php";
require "../app/views/errorView.php";
require "../app/views/partials/footer.php";
