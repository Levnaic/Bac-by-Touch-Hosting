<?php

use BacByTouch\Session;
use BacByTouch\Authenticator;

Session::sessionStart();
Authenticator::authenticateAdmin();

$title = "Create Producer";
$css = "form.css";

require "../app/views/partials/head.php";
require "../app/views/partials/adminNav.php";
require "../app/views/producers/createProducerView.php";
