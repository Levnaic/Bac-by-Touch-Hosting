<?php

// include
use BacByTouch\Authenticator;
use BacByTouch\Session;
use BacByTouch\ErrorHandler;
use BacByTouch\Redirect;
use BacByTouch\Database;
use BacByTouch\Security;
use Models\Event;


require "../config/config.php";

Session::sessionStart();
Authenticator::authenticateAdmin();

$db = new Database($databaseConfig);
$events = new Event($db->getConnection());

// searching by username
if (isset($_GET['searchTitle'])) {
    $filterValue = Security::sanitizeInput($_GET['searchTitle']);
    try {
        $filterValue = Security::validateInput($filterValue, "str");
        $rows = $events->getFilteredEventsByTitle($filterValue);
    } catch (\InvalidArgumentException $e) {
        ErrorHandler::logError("Validation Error", $e->getMessage(), "userCMSController", "20");
        Redirect::redirectToErrorPage(400);
    }
    // show all
} else $rows = $events->getAllEvents();

// view part
$title = "Events CMS";
$css = "adminCMS.css";

require "../app/views/partials/head.php";
require "../app/views/partials/adminNav.php";
require "../app/views/events/eventCMSView.php";
