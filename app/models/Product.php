<?php

namespace Models;

use BacByTouch\Debug;
use PDO;
use PDOException;
use BacByTouch\ErrorHandler;
use BacByTouch\Redirect;


class Product
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getAllProducts()
    {
        try {
            $query = $this->conn->prepare("SELECT * FROM products");

            $query->execute();
            $products = $query->fetchAll(PDO::FETCH_OBJ);

            $query->closeCursor();

            $productsChanged = $this->changeProducersIdForNames($products);

            return $productsChanged;
        } catch (PDOException $e) {
            $errorMessage = $e->getMessage();
            $sqlStatment = $query->queryString;
            ErrorHandler::logError("Database Error", $errorMessage . "|" . $sqlStatment, __CLASS__, __LINE__);
            Redirect::redirectToErrorPage(500);
        }
    }

    public function getProductById($id)
    {
        try {
            $query = $this->conn->prepare("SELECT * FROM products WHERE id = :id");

            $query->bindParam(":id", $id, PDO::PARAM_INT);

            $query->execute();

            $product = $query->fetch(PDO::FETCH_OBJ);

            $query->closeCursor();

            return $product;
        } catch (PDOException $e) {
            $errorMessage = $e->getMessage();
            $sqlStatment = $query->queryString;
            ErrorHandler::logError("Database Error", $errorMessage . "|" . $sqlStatment, __CLASS__, __LINE__);
            Redirect::redirectToErrorPage(500);
        }
    }

    public function getFilteredProductsByName($filterValue)
    {
        try {
            $query = $this->conn->prepare("SELECT * FROM products WHERE product_name LIKE :filterValue");

            $filterValue = "%" . $filterValue . "%";
            $query->bindParam(":filterValue", $filterValue, PDO::PARAM_STR);

            $query->execute();
            $products = $query->fetchAll(PDO::FETCH_OBJ);

            $query->closeCursor();

            $productsChanged = $this->changeProducersIdForNames($products);

            return $productsChanged;
        } catch (PDOException $e) {
            $errorMessage = $e->getMessage();
            $sqlStatment = $query->queryString;
            ErrorHandler::logError("Database Error", $errorMessage . "|" . $sqlStatment, __CLASS__, __LINE__);
            Redirect::redirectToErrorPage(500);
        }
    }

    //?UPDATE
    public function getFilteredProductsByProducer($filterValue)
    {
    }

    public function getProductsOfProducer($id)
    {
        try {
            $query = $this->conn->prepare("SELECT * FROM products WHERE producer_id = :id");

            $query->bindParam(":id", $id, PDO::PARAM_INT);

            $query->execute();
            $products = $query->fetchAll(PDO::FETCH_OBJ);

            $query->closeCursor();

            return $products;
        } catch (PDOException $e) {
            $errorMessage = $e->getMessage();
            $sqlStatment = $query->queryString;
            ErrorHandler::logError("Database Error", $errorMessage . "|" . $sqlStatment, __CLASS__, __LINE__);
            Redirect::redirectToErrorPage(500);
        }
    }



    protected function changeProducersIdForNames($products, $mode = 1)
    {
        try {
            $query = $this->conn->prepare("SELECT id, title FROM producers");

            $query->execute();
            $producers = $query->fetchAll(PDO::FETCH_OBJ);

            $query->closeCursor();

            $producersMap = [];
            foreach ($producers as $producer) {
                if ($mode == 1) {
                    // Change IDs to names
                    $producersMap[$producer->id] = $producer->title;
                } elseif ($mode == 2) {
                    // Change names to IDs
                    $producersMap[$producer->title] = $producer->id;
                }
            }
            // Debug::dd($producersMap);

            foreach ($products as $product) {
                if ($mode == 1 && isset($product->producer_id) && isset($producersMap[$product->producer_id])) {
                    $product->producer_name = $producersMap[$product->producer_id];
                } elseif ($mode == 2 && isset($product->producer_name) && isset($producersMap[$product->producer_name])) {
                    $product->producer_id = $producersMap[$product->producer_name];
                } else {
                    ErrorHandler::logError("Bad input", "There is no matching id for name or vice versa", __CLASS__, __LINE__);
                    Redirect::redirectToErrorPage(500);
                }
            }

            return $products;
        } catch (PDOException $e) {
            $errorMessage = $e->getMessage();
            $sqlStatment = $query->queryString;
            ErrorHandler::logError("Database Error", $errorMessage . "|" . $sqlStatment, __CLASS__, __LINE__);
            Redirect::redirectToErrorPage(500);
        }
    }

    public function addProduct($productName, $productProducer, $productPrice, $productInStock)
    {

        try {
            $query = $this->conn->prepare("INSERT INTO products (product_name, price, producer_id, in_stock) VALUES (:product_name, :price, :producer_id, :in_stock)");

            $query->bindParam(':product_name', $productName, PDO::PARAM_STR);
            $query->bindParam(':price', $productPrice, PDO::PARAM_INT);
            $query->bindParam(':producer_id', $productProducer, PDO::PARAM_INT);
            $query->bindParam(':in_stock', $productInStock, PDO::PARAM_INT);

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

    public function updateProduct($productName, $productProducer, $productPrice, $productInStock, $id)
    {
        try {
            $query = $this->conn->prepare("UPDATE products SET product_name = :product_name, price = :price, producer_id = :producer_id, in_stock = :in_stock WHERE id = :id");

            $query->bindParam(':product_name', $productName, PDO::PARAM_STR);
            $query->bindParam(':price', $productPrice, PDO::PARAM_INT);
            $query->bindParam(':producer_id', $productProducer, PDO::PARAM_INT);
            $query->bindParam(':in_stock', $productInStock, PDO::PARAM_INT);
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

    public function deleteProduct($id)
    {
        try {
            $query = $this->conn->prepare("DELETE FROM products WHERE id = :id");

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
