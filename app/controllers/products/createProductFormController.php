<?php

use BacByTouch\Session;
use BacByTouch\Authenticator;
use BacByTouch\Database;
use BacByTouch\Debug;
use Models\Producer;

require_once "../config/config.php";

Session::sessionStart();
Authenticator::authenticateAdmin();

$db = new Database($databaseConfig);
$producer = new Producer($db->getConnection());
$rows = $producer->getProducersNamesAndId();

// Debug::dd($rows);

$title = "Create Product";
$css = "form.css";

require "../app/views/partials/head.php";
require "../app/views/partials/adminNav.php";
require "../app/views/products/createProductView.php";
