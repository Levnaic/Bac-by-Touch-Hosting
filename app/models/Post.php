<?php

namespace Models;

use BacByTouch\ErrorHandler;
use BacByTouch\Redirect;
use PDO;
use PDOException;

class Post extends ErrorHandler
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getAllPosts()
    {
        try {
            $query = $this->conn->prepare("SELECT * FROM posts");

            $query->execute();
            $posts = $query->fetchAll(PDO::FETCH_OBJ);

            $query->closeCursor();

            return $posts;
        } catch (PDOException $e) {
            $errorMessage = $e->getMessage();
            $sqlStatment = $query->queryString;
            ErrorHandler::logError("Database Error", $errorMessage . "|" . $sqlStatment, __CLASS__, __LINE__);
            Redirect::redirectToErrorPage(500);
        }
    }

    public function getPostById($id)
    {
        try {
            $query = $this->conn->prepare("SELECT * FROM posts WHERE id = :id");

            $query->bindParam(":id", $id, PDO::PARAM_INT);

            $query->execute();
            $post = $query->fetch(PDO::FETCH_OBJ);

            $query->closeCursor();

            return $post;
        } catch (PDOException $e) {
            $errorMessage = $e->getMessage();
            $sqlStatment = $query->queryString;
            ErrorHandler::logError("Database Error", $errorMessage . "|" . $sqlStatment, __CLASS__, __LINE__);
            Redirect::redirectToErrorPage(500);
        }
    }

    public function getFilteredPostsByTitle($filterValue)
    {
        try {
            $query = $this->conn->prepare("SELECT * FROM posts WHERE title LIKE :filterValue");

            $filterValue = "%" . $filterValue . "%";
            $query->bindParam(":filterValue", $filterValue, PDO::PARAM_STR);

            $query->execute();
            $posts = $query->fetchAll(PDO::FETCH_OBJ);

            $query->closeCursor();

            return $posts;
        } catch (PDOException $e) {
            $errorMessage = $e->getMessage();
            $sqlStatment = $query->queryString;
            ErrorHandler::logError("Database Error", $errorMessage . "|" . $sqlStatment, __CLASS__, __LINE__);
            Redirect::redirectToErrorPage(500);
        }
    }

    public function getFilteredPostsByAuthor($filterValue)
    {
        try {
            $query = $this->conn->prepare("SELECT * FROM posts WHERE user_name LIKE :filterValue");

            $filterValue = "%" . $filterValue . "%";
            $query->bindParam(":filterValue", $filterValue, PDO::PARAM_STR);

            $query->execute();
            $posts = $query->fetchAll(PDO::FETCH_OBJ);

            $query->closeCursor();

            return $posts;
        } catch (PDOException $e) {
            $errorMessage = $e->getMessage();
            $sqlStatment = $query->queryString;
            ErrorHandler::logError("Database Error", $errorMessage . "|" . $sqlStatment, __CLASS__, __LINE__);
            Redirect::redirectToErrorPage(500);
        }
    }

    public function createNewPost($title, $subtitle, $body, $img, $imgAlt, $user_id, $user_name)
    {
        try {
            $query = $this->conn->prepare("INSERT INTO posts (title, subtitle, body, img, img_alt, user_id, user_name) VALUES (:title, :subtitle, :body, :img, :img_alt, :user_id, :user_name)");

            $query->bindParam(":title", $title, PDO::PARAM_STR);
            $query->bindParam(":subtitle", $subtitle, PDO::PARAM_STR);
            $query->bindParam(":body", $body, PDO::PARAM_STR);
            $query->bindParam(":img", $img, PDO::PARAM_STR);
            $query->bindParam(":img_alt", $imgAlt, PDO::PARAM_STR);
            $query->bindParam(":user_id", $user_id, PDO::PARAM_INT);
            $query->bindParam(":user_name", $user_name, PDO::PARAM_STR);

            $query->execute();

            $query->closeCursor();
        } catch (PDOException $e) {
            $errorMessage = $e->getMessage();
            $sqlStatment = $query->queryString;
            ErrorHandler::logError("Database Error", $errorMessage . "|" . $sqlStatment, __CLASS__, __LINE__);
            Redirect::redirectToErrorPage(500);
        }
    }

    public function updatePost($title, $subtitle, $body, $img, $imgAlt, $user_id, $user_name, $id)
    {
        try {
            if ($img === null) {
                $query = $this->conn->prepare("UPDATE posts SET title = :title, subtitle = :subtitle, body = :body, img_alt = :img_alt,  user_id = :user_id, user_name = :user_name WHERE id = :id");
            } else {
                $query = $this->conn->prepare("UPDATE posts SET title = :title, subtitle = :subtitle, body = :body, img = :img, img_alt = :img_alt,  user_id = :user_id, user_name = :user_name WHERE id = :id");
                $query->bindParam(":img", $img, PDO::PARAM_STR);
            }

            $query->bindParam(":title", $title, PDO::PARAM_STR);
            $query->bindParam(":subtitle", $subtitle, PDO::PARAM_STR);
            $query->bindParam(":body", $body, PDO::PARAM_STR);
            $query->bindParam(":img_alt", $imgAlt, PDO::PARAM_STR);
            $query->bindParam(":user_id", $user_id, PDO::PARAM_INT);
            $query->bindParam(":user_name", $user_name, PDO::PARAM_STR);
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

    public function deletePost($id)
    {
        try {
            $query = $this->conn->prepare("DELETE FROM posts WHERE id = :id");

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
