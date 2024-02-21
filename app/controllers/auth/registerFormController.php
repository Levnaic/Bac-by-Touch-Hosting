<?php

use BacByTouch\Authenticator;
use BacByTouch\Session;

Session::sessionStart();
Authenticator::authenticateNotLoggedIn();

$title = "Register";
$css = "form.css";

require "../app/views/partials/head.php";
require "../app/views/auth/registerView.php";

if (isset($_SESSION["registration_error"])) {
    $decodedErrorMessage = html_entity_decode($_SESSION["registration_error"], ENT_QUOTES, 'UTF-8');
    echo '<script>alert("' . htmlspecialchars_decode($decodedErrorMessage, ENT_QUOTES) . '")</script>';
    unset($_SESSION["registration_error"]);
}
