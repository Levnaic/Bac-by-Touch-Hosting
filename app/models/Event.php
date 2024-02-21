<?php

namespace Models;

use BacByTouch\Debug;
use PDO;
use PDOException;
use BacByTouch\ErrorHandler;
use BacByTouch\Redirect;
use BacByTouch\Security;

class Event
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }


    //* GET
    public function getAllEvents()
    {
        try {
            $query = $this->conn->prepare("SELECT * FROM events");

            $query->execute();
            $events = $query->fetchAll(PDO::FETCH_OBJ);

            $query->closeCursor();

            return $events;
        } catch (PDOException $e) {
            $errorMessage = $e->getMessage();
            $sqlStatment = $query->queryString;
            ErrorHandler::logError("Database Error", $errorMessage . "|" . $sqlStatment, __CLASS__, __LINE__);
            Redirect::redirectToErrorPage(500);
        }
    }

    public function getFilteredEventsByTitle($filterValue)
    {
        try {
            $query = $this->conn->prepare("SELECT * FROM events WHERE event_name LIKE :filterValue");

            $filterValue = "%" . $filterValue . "%";
            $query->bindParam(":filterValue", $filterValue, PDO::PARAM_STR);

            $query->execute();
            $events = $query->fetchAll(PDO::FETCH_OBJ);

            $query->closeCursor();

            return $events;
        } catch (PDOException $e) {
            $errorMessage = $e->getMessage();
            $sqlStatment = $query->queryString;
            ErrorHandler::logError("Database Error", $errorMessage . "|" . $sqlStatment, __CLASS__, __LINE__);
            Redirect::redirectToErrorPage(500);
        }
    }

    public function getEventById($id)
    {
        try {
            $query = $this->conn->prepare("SELECT * FROM events WHERE id = :id");

            $query->bindParam(":id", $id, PDO::PARAM_INT);

            $query->execute();

            $event = $query->fetch(PDO::FETCH_OBJ);

            $query->closeCursor();

            return $event;
        } catch (PDOException $e) {
            $errorMessage = $e->getMessage();
            $sqlStatment = $query->queryString;
            ErrorHandler::logError("Database Error", $errorMessage . "|" . $sqlStatment, __CLASS__, __LINE__);
            Redirect::redirectToErrorPage(500);
        }
    }

    public function getEventsForJson()
    {
        try {
            $query = $this->conn->prepare("SELECT id, event_name, event_description, event_date, is_every_year FROM events");
            $query->execute();

            $events = $query->fetchAll(PDO::FETCH_OBJ);

            $query->closeCursor();

            $formattedEvents = [];
            foreach ($events as $event) {
                $eventDate = new \DateTime($event->event_date);

                if ($event->is_every_year == 1) $isEveryYear = true;
                else $isEveryYear = false;

                $formattedEvent = [
                    'id' => "$event->id",
                    'name' => "$event->event_name",
                    'description' => $event->event_description,
                    'date' => $eventDate->format('m/d/y'),
                    'everyYear' => $isEveryYear,
                    'type' => 'holiday',
                ];
                $formattedEvents[] = $formattedEvent;
            }
            return $formattedEvents;
        } catch (PDOException $e) {
            $errorMessage = $e->getMessage();
            $sqlStatment = $query->queryString;
            ErrorHandler::logError("Database Error", $errorMessage . "|" . $sqlStatment, __CLASS__, __LINE__);
            Redirect::redirectToErrorPage(500);
        }
    }


    //* CRUD

    public function addEvent($eventName, $eventDate, $description, $isEveryYear, $text, $img, $imgAlt, $type = "holiday")
    {
        try {
            $query = $this->conn->prepare("INSERT INTO events (event_name, event_date, event_type, event_description, is_every_year, event_text, img, img_alt) VALUES (:event_name, :event_date, :event_type, :event_description, :is_every_year, :event_text, :img, :img_alt)");

            $query->bindParam(':event_name', $eventName, PDO::PARAM_STR);
            $query->bindParam(':event_date', $eventDate, PDO::PARAM_STR);
            $query->bindParam(':event_type', $type, PDO::PARAM_STR);
            $query->bindParam(':event_description', $description, PDO::PARAM_STR);
            $query->bindParam(':is_every_year', $isEveryYear, PDO::PARAM_BOOL);
            $query->bindParam(':event_text', $text, PDO::PARAM_STR);
            $query->bindParam(':img', $img, PDO::PARAM_STR);
            $query->bindParam(':img_alt', $imgAlt, PDO::PARAM_STR);

            $query->execute();

            $query->closeCursor();

            $this->generateEventsJson();

            return true;
        } catch (PDOException $e) {
            $errorMessage = $e->getMessage();
            $sqlStatment = $query->queryString;
            ErrorHandler::logError("Database Error", $errorMessage . "|" . $sqlStatment, __CLASS__, __LINE__);
            Redirect::redirectToErrorPage(500);
        }
    }

    public function updateEvent($eventName, $eventDate, $description, $isEveryYear, $text, $img, $imgAlt, $id, $type = "holiday")
    {
        try {
            if ($img === null) {
                $query = $this->conn->prepare("UPDATE events SET event_name = :event_name, event_date = :event_date, event_type = :event_type, event_description = :event_description, is_every_year = :is_every_year, event_text = :event_text, img_alt = :img_alt WHERE id = :id");
            } else {
                $query = $this->conn->prepare("UPDATE events SET event_name = :event_name, event_date = :event_date, event_type = :event_type, event_description = :event_description, is_every_year = :is_every_year, event_text = :event_text, img = :img, img_alt = :img_alt WHERE id = :id");
                $query->bindParam(":img", $img, PDO::PARAM_STR);
            }

            $query->bindParam(':event_name', $eventName, PDO::PARAM_STR);
            $query->bindParam(':event_date', $eventDate, PDO::PARAM_STR);
            $query->bindParam(':event_type', $type, PDO::PARAM_STR);
            $query->bindParam(':event_description', $description, PDO::PARAM_STR);
            $query->bindParam(':is_every_year', $isEveryYear, PDO::PARAM_BOOL);
            $query->bindParam(':event_text', $text, PDO::PARAM_STR);
            $query->bindParam(':img_alt', $imgAlt, PDO::PARAM_STR);
            $query->bindParam(':id', $id, PDO::PARAM_INT);

            $query->execute();

            $query->closeCursor();

            $this->generateEventsJson();

            return true;
        } catch (PDOException $e) {
            $errorMessage = $e->getMessage();
            $sqlStatment = $query->queryString;
            ErrorHandler::logError("Database Error", $errorMessage . "|" . $sqlStatment, __CLASS__, __LINE__);
            Redirect::redirectToErrorPage(500);
        }
    }

    public function deleteEvent($id)
    {
        try {
            $query = $this->conn->prepare("DELETE FROM events WHERE id = :id");

            $query->bindParam(":id", $id, PDO::PARAM_INT);

            $query->execute();

            $query->closeCursor();

            $this->generateEventsJson();
        } catch (PDOException $e) {
            $errorMessage = $e->getMessage();
            $sqlStatment = $query->queryString;
            ErrorHandler::logError("Database Error", $errorMessage . "|" . $sqlStatment, __CLASS__, __LINE__);
            Redirect::redirectToErrorPage(500);
        }
    }

    protected function generateEventsJson()
    {
        try {

            $this->makeJsonBackup();

            $events = $this->getEventsForJson();

            $path = realpath(__DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "data" . DIRECTORY_SEPARATOR . "json");
            $sourceFile = $path . DIRECTORY_SEPARATOR . "events.json";
            $jsonEvents = json_encode($events, JSON_HEX_QUOT | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_PRETTY_PRINT);
            file_put_contents($sourceFile, $jsonEvents);
        } catch (PDOException $e) {
            $errorMessage = $e->getMessage();
            ErrorHandler::logError("Database Error", $errorMessage, __CLASS__, __LINE__);
            Redirect::redirectToErrorPage(500);
        } catch (\InvalidArgumentException $e) {
            ErrorHandler::logError("Validation Error", $e->getMessage(), __CLASS__, __LINE__);
            Redirect::redirectToErrorPage(400);
        }
    }

    protected function makeJsonBackup()
    {
        try {
            $path = realpath(__DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "data" . DIRECTORY_SEPARATOR . "json");
            $sourceFile = $path . DIRECTORY_SEPARATOR . "events.json";
            if (!file_exists($sourceFile)) {
                throw new \Exception("Source file does not exist.");
            }

            $backupFile = $path . DIRECTORY_SEPARATOR . "events-backup.json";
            if (!rename($sourceFile, $backupFile)) {
                throw new \Exception("Failed to rename the file.");
            }
        } catch (\Exception $e) {
            ErrorHandler::logError("Backup Error", $e->getMessage(), __CLASS__, __LINE__);
            Redirect::redirectToErrorPage(500);
        }
    }
}
