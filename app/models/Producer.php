<?php

namespace Models;

use PDO;
use PDOException;
use BacByTouch\ErrorHandler;
use BacByTouch\Redirect;

class Producer
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getAllProducers()
    {
        try {
            $query = $this->conn->prepare("SELECT * FROM producers");

            $query->execute();
            $producers = $query->fetchAll(PDO::FETCH_OBJ);

            $query->closeCursor();

            return $producers;
        } catch (PDOException $e) {
            $errorMessage = $e->getMessage();
            $sqlStatment = $query->queryString;
            ErrorHandler::logError("Database Error", $errorMessage . "|" . $sqlStatment, __CLASS__, __LINE__);
            Redirect::redirectToErrorPage(500);
        }
    }

    public function getProducersNamesAndId()
    {
        try {
            $query = $this->conn->prepare("SELECT id, title FROM producers");

            $query->execute();
            $producers = $query->fetchAll(PDO::FETCH_OBJ);

            $query->closeCursor();

            return $producers;
        } catch (PDOException $e) {
            $errorMessage = $e->getMessage();
            $sqlStatment = $query->queryString;
            ErrorHandler::logError("Database Error", $errorMessage . "|" . $sqlStatment, __CLASS__, __LINE__);
            Redirect::redirectToErrorPage(500);
        }
    }

    public function getProducerById($id)
    {
        try {
            $query = $this->conn->prepare("SELECT * FROM producers WHERE id = :id");

            $query->bindParam(":id", $id, PDO::PARAM_INT);

            $query->execute();

            $producer = $query->fetch(PDO::FETCH_OBJ);

            $query->closeCursor();

            return $producer;
        } catch (PDOException $e) {
            $errorMessage = $e->getMessage();
            $sqlStatment = $query->queryString;
            ErrorHandler::logError("Database Error", $errorMessage . "|" . $sqlStatment, __CLASS__, __LINE__);
            Redirect::redirectToErrorPage(500);
        }
    }

    public function getFilteredProducersByTitle($filterValue)
    {
        try {
            $query = $this->conn->prepare("SELECT * FROM producers WHERE title LIKE :filterValue");

            $filterValue = "%" . $filterValue . "%";
            $query->bindParam(":filterValue", $filterValue, PDO::PARAM_STR);

            $query->execute();
            $producers = $query->fetchAll(PDO::FETCH_OBJ);

            $query->closeCursor();

            return $producers;
        } catch (PDOException $e) {
            $errorMessage = $e->getMessage();
            $sqlStatment = $query->queryString;
            ErrorHandler::logError("Database Error", $errorMessage . "|" . $sqlStatment, __CLASS__, __LINE__);
            Redirect::redirectToErrorPage(500);
        }
    }

    public function getProducerEmailById($id)
    {
        try {
            $query = $this->conn->prepare("SELECT email FROM producers WHERE id = :id");

            $query->bindParam(":id", $id, PDO::PARAM_INT);

            $query->execute();

            $producer = $query->fetch(PDO::FETCH_OBJ);

            $query->closeCursor();

            return $producer;
        } catch (PDOException $e) {
            $errorMessage = $e->getMessage();
            $sqlStatment = $query->queryString;
            ErrorHandler::logError("Database Error", $errorMessage . "|" . $sqlStatment, __CLASS__, __LINE__);
            Redirect::redirectToErrorPage(500);
        }
    }

    public function addProducer($title, $email, $contact, $location, $body, $latitude, $longitude, $popupMsg, $category)
    {
        try {
            $query = $this->conn->prepare("INSERT INTO producers (title, email, contact, producerLocation, body, latitude, longitude, popupMsg, category) VALUES (:title, :email, :contact, :producerLocation, :body, :latitude, :longitude, :popupMsg, :category)");

            $query->bindParam(':title', $title, PDO::PARAM_STR);
            $query->bindParam(':email', $email, PDO::PARAM_STR);
            $query->bindParam(':contact', $contact, PDO::PARAM_STR);
            $query->bindParam(':producerLocation', $location, PDO::PARAM_STR);
            $query->bindParam(':body', $body, PDO::PARAM_STR);
            $query->bindParam(':latitude', $latitude, PDO::PARAM_STR);
            $query->bindParam(':longitude', $longitude, PDO::PARAM_STR);
            $query->bindParam(':popupMsg', $popupMsg, PDO::PARAM_STR);
            $query->bindParam(':category', $category, PDO::PARAM_STR);

            $query->execute();

            $query->closeCursor();

            return true;
        } catch (PDOException $e) {
            $errorMessage = $e->getMessage();
            $sqlStatment = $query->queryString;
            ErrorHandler::logError("Database Error", $errorMessage . "|" . $sqlStatment, __CLASS__, __LINE__);
            Redirect::redirectToErrorPage(500);
        }
    }

    public function updateProducer($title, $email, $contact, $location, $body, $latitude, $longitude, $popupMsg, $category, $id)
    {
        try {
            $query = $this->conn->prepare("UPDATE producers SET title = :title, email = :email, contact = :contact, producerLocation = :producerLocation, body = :body, latitude = :latitude, longitude = :longitude, popupMsg = :popupMsg, category = :category WHERE id = :id");


            $query->bindParam(':title', $title, PDO::PARAM_STR);
            $query->bindParam(':email', $email, PDO::PARAM_STR);
            $query->bindParam(':contact', $contact, PDO::PARAM_STR);
            $query->bindParam(':producerLocation', $location, PDO::PARAM_STR);
            $query->bindParam(':body', $body, PDO::PARAM_STR);
            $query->bindParam(':latitude', $latitude, PDO::PARAM_STR);
            $query->bindParam(':longitude', $longitude, PDO::PARAM_STR);
            $query->bindParam(':popupMsg', $popupMsg, PDO::PARAM_STR);
            $query->bindParam(':category', $category, PDO::PARAM_STR);
            $query->bindParam(":id", $id, PDO::PARAM_INT);

            $query->execute();

            $query->closeCursor();

            return true;
        } catch (PDOException $e) {
            $errorMessage = $e->getMessage();
            $sqlStatment = $query->queryString;
            ErrorHandler::logError("Database Error", $errorMessage . "|" . $sqlStatment, __CLASS__, __LINE__);
            Redirect::redirectToErrorPage(500);
        }
    }

    public function deleteProducer($id)
    {
        try {
            $query = $this->conn->prepare("DELETE FROM producers WHERE id = :id");

            $query->bindParam(":id", $id, PDO::PARAM_INT);

            $query->execute();

            $query->closeCursor();
        } catch (PDOException $e) {
            $errorMessage = $e->getMessage();
            $sqlStatment = $query->queryString;
            ErrorHandler::logError("Database Error", $errorMessage . "|" . $sqlStatment, __CLASS__, __LINE__);
            Redirect::redirectToErrorPage(500);
        }
    }
}
