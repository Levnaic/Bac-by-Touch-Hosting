<?php

use BacByTouch\Authenticator;
use BacByTouch\Session;

Session::sessionStart();
Authenticator::authenticateAdmin();


$title = "Dashboard";
$css = "dashboard.css";

require "../app/views/partials/head.php";
require "../app/views/adminDashboardView.php";
