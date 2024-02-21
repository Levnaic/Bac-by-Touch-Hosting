<?php

// include
use BacByTouch\Authenticator;
use BacByTouch\Session;
use BacByTouch\ErrorHandler;
use BacByTouch\Redirect;
use BacByTouch\Database;
use BacByTouch\Security;
use Models\Producer;


require "../config/config.php";

Session::sessionStart();
Authenticator::authenticateAdmin();

$db = new Database($databaseConfig);
$posts = new Producer($db->getConnection());

// searching by title
if (isset($_GET['searchTitle'])) {
    $filterValue = Security::sanitizeInput($_GET['searchTitle']);
    try {
        $filterValue = Security::validateInput($filterValue, "txt");
        $rows = $posts->getFilteredProducersByTitle($filterValue);
    } catch (\InvalidArgumentException $e) {
        ErrorHandler::logError("Validation Error", $e->getMessage(), "producerCMSController", __LINE__);
        Redirect::redirectToErrorPage(400);
    }
    // show all
} else $rows = $posts->getAllProducers();

// view part
$title = "Producers CMS";
$css = "adminCMS.css";

require "../app/views/partials/head.php";
require "../app/views/partials/adminNav.php";
require "../app/views/producers/producersCMSView.php";
