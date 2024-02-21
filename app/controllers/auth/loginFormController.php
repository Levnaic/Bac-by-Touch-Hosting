<?php

use BacByTouch\Authenticator;
use BacByTouch\Session;

Session::sessionStart();
Authenticator::authenticateNotLoggedIn();

$title = "Login";
$css = "form.css";

require "../app/views/partials/head.php";
require "../app/views/auth/loginView.php";

if (isset($_SESSION['loginFailed']) && $_SESSION["loginFailed"] === 1) {
    echo '<script>alert("Uneli ste netačne podatke")</script>';
    $_SESSION["loginFailed"] = 0;
}
