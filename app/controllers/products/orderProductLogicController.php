<?php

use BacByTouch\Security;
use BacByTouch\ErrorHandler;
use BacByTouch\Redirect;
use BacByTouch\Session;
use BacByTouch\Authenticator;
use BacByTouch\Database;
use BacByTouch\Debug;
use BacByTouch\Mailer;
use Models\Producer;


require "../config/config.php";

Session::sessionStart();
Authenticator::authenticateUserOrAdmin();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['name'], $_POST['email'], $_POST['priceSum'], $_GET['id'])) {

        $orderedProducts = [];
        foreach ($_POST as $key => $value) {
            // Check if the input name starts with 'product' to identify product quantities
            if (strpos($key, 'product') === 0 && $value > 0) {
                $productName = substr($key, 7); // Extract product name from input name
                $productName = str_replace('_', ' ', $productName);
                $productName = Security::sanitizeInput($productName);
                $value = Security::sanitizeInput($value);
                $orderedProducts[$productName] = (int)$value;
            }
        }

        // sanitation of data
        $customerName = Security::sanitizeInput($_POST["name"]);
        $customerEmail = Security::sanitizeInput($_POST["email"]);
        $customerPhoneNumber = Security::sanitizeInput($_POST["phone"]);
        $customerMessage = Security::sanitizeInput($_POST["message"]);
        $priceSum = Security::sanitizeInput($_POST["priceSum"]);
        $producerId = Security::sanitizeInput($_GET["id"]);

        try {
            // validation of data
            $customerName = Security::validateInput($customerName, "txt");
            $customerEmail = Security::validateInput($customerEmail, "email");
            $customerPhoneNumber = Security::validateInput($customerPhoneNumber, "phone");
            $customerMessage = Security::validateInput($customerMessage, "txt");
            $priceSum = Security::validateInput($priceSum, "int");
            $producerId = Security::validateInput($producerId, "int");
            foreach ($orderedProducts as $key => $value) {
                Security::validateInput($key, "txt");
                Security::validateInput($value, "int");
            }

            //message in email
            $emailContent = "Poručilac: $customerName <br>";
            $emailContent .= "Poruka poručioca: $customerMessage <br>";
            $emailContent .= "<br>";
            $emailContent .= "Naručeni proizvodi:<br>";
            foreach ($orderedProducts as $productName => $quantity) {
                $emailContent .= "$productName: $quantity <br>";
            }
            $emailContent .= "<br>";
            $emailContent .= "Ukupna cena: $priceSum dinara<br>";
            $emailContent .= "<br>";
            $emailContent .= "Kontakt poručioca: <br>";
            $emailContent .= "Email: $customerEmail <br>";
            $emailContent .= "Broj telefona: $customerPhoneNumber";

            //!samo za lokal
            // Debug::dd($emailContent);

            //getting producers email
            $db = new Database($databaseConfig);

            $producer = new Producer($db->getConnection());

            $producerEmail = $producer->getProducerEmailById($producerId);

            //sending email
            $emailModel = new Mailer();
            $result = $emailModel->sendEmail($producerEmail->email, "Narudzbina sa Bac by Touch sajta", $emailContent);

            //redirecting to page for sent email
            header("Location: /products/order/made");
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
