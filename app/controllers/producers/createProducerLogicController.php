<?php

use BacByTouch\Security;
use BacByTouch\ErrorHandler;
use BacByTouch\Redirect;
use BacByTouch\Session;
use BacByTouch\Authenticator;
use BacByTouch\Database;
use BacByTouch\Debug;
use Models\Producer;

require "../config/config.php";

Session::sessionStart();
Authenticator::authenticateAdmin();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['mapTitle'], $_POST['email'], $_POST['mapBody'], $_POST['mapLatitude'], $_POST['mapLongitude'], $_POST['popupMsg'], $_POST['category'])) {
        // sanitation of data
        $title = Security::sanitizeInput($_POST["mapTitle"]);
        $email = Security::sanitizeInput($_POST["email"]);
        $body = Security::sanitizeInput($_POST["mapBody"]);
        $latitude = Security::sanitizeInput($_POST["mapLatitude"]);
        $longitude = Security::sanitizeInput($_POST["mapLongitude"]);
        $popupMsg = Security::sanitizeInput($_POST["popupMsg"]);
        $category = Security::sanitizeInput($_POST["category"]);

        // Validation of data only if contact and location are provided
        if (!empty($_POST['contact'])) {
            $contact = Security::sanitizeInput($_POST["contact"]);
            $contact = Security::validateInput($contact, "phone");
        }

        if (!empty($_POST['location'])) {
            $location = Security::sanitizeInput($_POST["location"]);
            $location = Security::validateInput($location, "txt");
        }

        try {
            $title = Security::validateInput($title, "txt");
            $email = Security::validateInput($email, "email");
            $body = Security::validateInput($body, "txt");
            $latitude = Security::validateInput($latitude, "float");
            $longitude = Security::validateInput($longitude, "float");
            $popupMsg = Security::validateInput($popupMsg, "txt");
            $category = Security::validateInput($category, "str");

            $db = new Database($databaseConfig);
            $producer = new Producer($db->getConnection());
            $producer->addProducer($title, $email, $contact ?? null, $location ?? null, $body, $latitude, $longitude, $popupMsg, $category);

            header("Location: /dashboard/producers");
            exit;
        } catch (\InvalidArgumentException $e) {
            ErrorHandler::logError("Validation Error", $e->getMessage(), "createProducerLogicController", __LINE__);
            Redirect::redirectToErrorPage(400);
        }
    } else {
        ErrorHandler::logError("Missing input fields", "missing input fields in form", "createProducerLogicController", __LINE__);
        Redirect::redirectToErrorPage(400);
    }
} else {
    ErrorHandler::logError("Invalid method", "Not a valid POST method", "createProducerLogicController", __LINE__);
    Redirect::redirectToErrorPage(400);
}
