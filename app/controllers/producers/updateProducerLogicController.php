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
    if (isset($_POST['title'], $_POST['email'], $_POST['body'], $_POST['latitude'], $_POST['longitude'], $_POST['popupMsg'], $_POST['category'], $_GET["id"])) {
        // sanitation of data
        $title = Security::sanitizeInput($_POST["title"]);
        $email = Security::sanitizeInput($_POST["email"]);
        $body = Security::sanitizeInput($_POST["body"]);
        $latitude = Security::sanitizeInput($_POST["latitude"]);
        $longitude = Security::sanitizeInput($_POST["longitude"]);
        $popupMsg = Security::sanitizeInput($_POST["popupMsg"]);
        $category = Security::sanitizeInput($_POST["category"]);
        $id = Security::sanitizeInput($_GET["id"]);

        // Check if contact and location are provided before validating
        $contact = isset($_POST['contact']) ? Security::sanitizeInput($_POST["contact"]) : null;
        $location = isset($_POST['location']) ? Security::sanitizeInput($_POST["location"]) : null;

        try {
            // validation of data
            $title = Security::validateInput($title, "txt");
            $email = Security::validateInput($email, "email");
            $body = Security::validateInput($body, "txt");
            $latitude = Security::validateInput($latitude, "float");
            $longitude = Security::validateInput($longitude, "float");
            $popupMsg = Security::validateInput($popupMsg, "txt");
            $category = Security::validateInput($category, "str");
            $id = Security::validateInput($id, "int");

            $db = new Database($databaseConfig);
            $producer = new Producer($db->getConnection());

            // Pass null values for contact and location if not provided
            $producer->updateProducer($title, $email, $contact, $location, $body, $latitude, $longitude, $popupMsg, $category, $id);

            header("Location: /dashboard/producers");
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
    ErrorHandler::logError("Invalid method", "Not a valid POST method", __FILE__, __LINE__);
    Redirect::redirectToErrorPage(400);
}
