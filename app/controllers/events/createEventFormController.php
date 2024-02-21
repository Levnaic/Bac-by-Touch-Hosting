<?php

use BacByTouch\Session;
use BacByTouch\Authenticator;

Session::sessionStart();
Authenticator::authenticateAdmin();

$title = "Create Event";
$css = "form.css";

require "../app/views/partials/head.php";
require "../app/views/partials/adminNav.php";
require "../app/views/events/createEventView.php";
