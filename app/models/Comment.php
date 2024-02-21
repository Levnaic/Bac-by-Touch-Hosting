<?php

namespace Models;

use PDO;
use PDOException;
use BacByTouch\ErrorHandler;
use BacByTouch\Redirect;

class Comment
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getAllCommentsOfProducer($id)
    {
        try {
            $query = $this->conn->prepare("SELECT * FROM map_comments WHERE marker_id = :id");

            $query->bindParam(':id', $id, PDO::PARAM_INT);

            $query->execute();
            $comments = $query->fetchAll(PDO::FETCH_OBJ);

            $query->closeCursor();

            $comments = array_reverse($comments);
            return $comments;
        } catch (PDOException $e) {
            $errorMessage = $e->getMessage();
            $sqlStatment = $query->queryString;
            ErrorHandler::logError("Database Error", $errorMessage . "|" . $sqlStatment, __CLASS__, __LINE__);
            Redirect::redirectToErrorPage(500);
        }
    }

    public function addComment($markerID, $commentTxt, $rating, $username)
    {
        try {
            $query = $this->conn->prepare("INSERT INTO map_comments (marker_id, username, comment_text, rating) VALUES (:marker_id, :username, :comment_text, :rating)");

            $query->bindParam("marker_id", $markerID, PDO::PARAM_INT);
            $query->bindParam("username", $username, PDO::PARAM_STR);
            $query->bindParam("comment_text", $commentTxt, PDO::PARAM_STR);
            $query->bindParam("rating", $rating, PDO::PARAM_INT);

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
