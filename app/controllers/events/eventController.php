<?php

use BacByTouch\Database;
use BacByTouch\Session;
use BacByTouch\Security;
use BacByTouch\ErrorHandler;
use BacByTouch\Redirect;
use Models\Event;

require "../config/config.php";

Session::sessionStart();

$db = new Database($databaseConfig);
$event = new Event($db->getConnection());

if (isset($_GET["id"])) {
    $id = Security::sanitizeInput($_GET["id"]);

    try {
        $id = Security::validateInput($id, "int");
        $row = $event->getEventById($id);
        $row->event_date = (new DateTime($row->event_date))->format('d.m.Y');
    } catch (\InvalidArgumentException $e) {
        ErrorHandler::logError("Validation Error", $e->getMessage(), __FILE__, __LINE__);
        Redirect::redirectToErrorPage(400);
    }
} else {
    ErrorHandler::logError("missing GET parameter", "no GET parameter", __FILE__, __LINE__);
    Redirect::redirectToErrorPage(400);
}

$title = "Event";
$css = "event.css";

require "../app/views/partials/head.php";
require "../app/views/partials/nav.php";
require "../app/views/events/eventView.php";
require "../app/views/partials/footer.php";
