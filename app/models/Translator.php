<?php

namespace Models;

use BacByTouch\ErrorHandler;
use BacByTouch\Redirect;
use PDO;
use PDOException;

class Translator
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    //* GET

    public  function getTranslations($page, $lang)
    {
        try {
            $query = $this->conn->prepare("SELECT * FROM translations WHERE page_name = :page_name AND lang = :lang");

            $query->bindParam(":page_name", $page, PDO::PARAM_STR);
            $query->bindParam(":lang", $lang, PDO::PARAM_STR);

            $query->execute();

            // fetching translations for that page
            $translations = $query->fetchAll(PDO::FETCH_ASSOC);

            $query->closeCursor();

            $keyValueTranslations = array();

            // making keyValue array from translations
            foreach ($translations as $translation) {
                $keyValueTranslations[$translation['reference']] = $translation['translation'];
            }

            return $keyValueTranslations;
        } catch (PDOException $e) {
            $errorMessage = $e->getMessage();
            $sqlStatment = $query->queryString;
            ErrorHandler::logError("Database Error", $errorMessage . "|" . $sqlStatment, __CLASS__, __LINE__);
            Redirect::redirectToErrorPage(500);
        }
    }
}
