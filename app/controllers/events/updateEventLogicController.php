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
    if (isset($_POST['eventName'], $_POST['eventText'], $_POST['eventDate'], $_POST['eventDescription'], $_POST['imgAlt'], $_GET["id"])) {
        // sanitation of data
        $name = Security::sanitizeInput($_POST["eventName"]);
        $text = Security::sanitizeInput($_POST["eventText"]);
        $date = Security::sanitizeInput($_POST["eventDate"]);
        $description = Security::sanitizeInput($_POST['eventDescription']);
        $isEveryYear = isset($_POST["everyYear"]) && $_POST["everyYear"] === "on";
        $isEveryYear = $isEveryYear ? true : false;
        $imgAlt = Security::sanitizeInput($_POST['imgAlt']);
        $id = Security::sanitizeInput($_GET["id"]);

        $img = isset($_FILES['img']) ? $_FILES['img'] : null;
        $imgPath = null;

        try {
            // validation of data
            $name = Security::validateInput($name, "txt");
            $text = Security::validateInput($text, "txt");
            $date = Security::validateInput($date, "date");
            $description = Security::validateInput($description, "txt");
            $imgAlt = Security::validateInput($imgAlt, "txt");
            $id = Security::validateInput($id, "int");

            if ($img && $img['size'] > 0) {
                $imgPath = Security::validateImgUpload($img, "events-img");
            }

            $db = new Database($databaseConfig);
            $event = new Event($db->getConnection());

            $event->updateEvent($name, $date, $description, $isEveryYear, $text,  $imgPath, $imgAlt, $id);

            header("Location: /dashboard/events");
            exit;
        } catch (\InvalidArgumentException $e) {
            ErrorHandler::logError("Validation Error", $e->getMessage(), __FILE__, __LINE__);
            Redirect::redirectToErrorPage(400);
        }
    } else {
        ErrorHandler::logError("Missing input fields", "missing input fields in form", __FILE__, __LINE__);
        Redirect::redirectToErrorPage(400);
    }
} else {
    ErrorHandler::logError("Invalid method", "Not a balid POST method", __FILE__, __LINE__);
    Redirect::redirectToErrorPage(400);
}
