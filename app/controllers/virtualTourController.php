<?php

require "../config/config.php";

use BacByTouch\Database;
use BacByTouch\Debug;
use BacByTouch\Session;
use Models\Translator;

Session::sessionStart();

$lang = $_COOKIE['language'] ?? "sr";

$db = new Database($databaseConfig);

$translator = new Translator($db->getConnection());
$translations = $translator->getTranslations("virtualTour", $lang);


$title = "Virtual Tour";
$css = "virtual-tour.css";

require "../app/views/partials/head.php";
require "../app/views/partials/nav.php";
require "../app/views/virtualTourView.php";
require "../app/views/partials/footer.php";
