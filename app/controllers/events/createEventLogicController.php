<?php

use BacByTouch\Security;
use BacByTouch\ErrorHandler;
use BacByTouch\Redirect;
use BacByTouch\Session;
use BacByTouch\Authenticator;
use BacByTouch\Database;
use BacByTouch\Debug;
use Models\Event;

require "../config/config.php";

Session::sessionStart();
Authenticator::authenticateAdmin();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['eventName'], $_POST['eventText'], $_POST['eventDate'], $_POST['eventDescription'], $_FILES['img'], $_POST['imgAlt'])) {
        // sanitation of data
        $name = Security::sanitizeInput($_POST["eventName"]);
        $text = Security::sanitizeInput($_POST["eventText"]);
        $date = Security::sanitizeInput($_POST["eventDate"]);
        $description = Security::sanitizeInput($_POST['eventDescription']);
        $isEveryYear = isset($_POST["everyYear"]) && $_POST["everyYear"] === "on";
        $isEveryYear = $isEveryYear ? true : false;
        $imgAlt = Security::sanitizeInput($_POST['imgAlt']);
        try {
            // validation of data
            $name = Security::validateInput($name, "txt");
            $text = Security::validateInput($text, "txt");
            $date = Security::validateInput($date, "date");
            $description = Security::validateInput($description, "txt");
            $imgAlt = Security::validateInput($imgAlt, "txt");
            $imgPath = Security::validateImgUpload($_FILES['img'], "events-img");

            $db = new Database($databaseConfig);
            $event = new Event($db->getConnection());
            $event->addEvent($name, $date, $description, $isEveryYear, $text, $imgPath, $imgAlt);

            header("Location: /dashboard/events");
            exit;
        } catch (\InvalidArgumentException $e) {
            ErrorHandler::logError("Validation Error", $e->getMessage(), "createEventLogicController", __LINE__);
            Redirect::redirectToErrorPage(400);
        }
    } else {
        ErrorHandler::logError("Missing input fields", "missing input fields in form", "createEventLogicController", __LINE__);
        Redirect::redirectToErrorPage(400);
    }
} else {
    ErrorHandler::logError("Invalid method", "Not a balid POST method", "createEventLogicController", __LINE__);
    Redirect::redirectToErrorPage(400);
}
