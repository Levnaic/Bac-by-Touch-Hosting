<?php

use BacByTouch\Session;
use BacByTouch\Authenticator;

Session::sessionStart();
Authenticator::authenticateUserOrAdmin();

$title = "Order Made";
$css = "orderMade.css";

require "../app/views/partials/head.php";
require "../app/views/partials/nav.php";
require "../app/views/products/orderMadeView.php";
require "../app/views/partials/footer.php";
