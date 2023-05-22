<?php

namespace controllers;

use models\Book;
use models\Dvd;
use models\Furniture;
use PDO;

class ProductController
{

    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function getAllProducts(): array
    {
        try {
            $sql = "SELECT * FROM products";
            $stmt = $this->conn->query($sql);
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $results;
        } catch (\PDOException $e) {
            throw new \Exception("Error retrieving products: {$e->getMessage()}");
        }
    }

    public function saveBook(Book $product)
    {
        try {
            $insert_statement = $this->conn->prepare("INSERT INTO products (SKU, name, price, weight) VALUES (:sku, :name, :price, :weight)");

            $sku = $product->getSKU();
            $name = $product->getName();
            $price = $product->getPrice();
            $weight = $product->getWeight();

            $insert_statement->bindParam(':sku', $sku);
            $insert_statement->bindParam(':name', $name);
            $insert_statement->bindParam(':price', $price);
            $insert_statement->bindParam(':weight', $weight);

            $insert_statement->execute();

        } catch (\PDOException $e) {
            throw new \Exception("Error saving products: {$e->getMessage()}");
        }
    }

    public function saveDvd(Dvd $product){
        try {
            $insert_statement = $this->conn->prepare("INSERT INTO products (SKU, name, price, size) VALUES (:sku, :name, :price, :size)");

            $sku = $product->getSKU();
            $name = $product->getName();
            $price = $product->getPrice();
            $size = $product->getSize();

            $insert_statement->bindParam(':sku', $sku);
            $insert_statement->bindParam(':name', $name);
            $insert_statement->bindParam(':price', $price);
            $insert_statement->bindParam(':size', $size);

            $insert_statement->execute();

        } catch (\PDOException $e) {
            throw new \Exception("Error saving products: {$e->getMessage()}");
        }
    }

    public function saveFurniture(Furniture $product){
        try {
            $insert_statement = $this->conn->prepare("INSERT INTO products (SKU, name, price, height, width, length) VALUES (:sku, :name, :price, :height, :width, :length)");

            $sku = $product->getSKU();
            $name = $product->getName();
            $price = $product->getPrice();
            $height = $product->getHeight();
            $width = $product->getWidth();
            $length = $product->getLength();


            $insert_statement->bindParam(':sku', $sku);
            $insert_statement->bindParam(':name', $name);
            $insert_statement->bindParam(':price', $price);
            $insert_statement->bindParam(':height', $height);
            $insert_statement->bindParam(':width', $width);
            $insert_statement->bindParam('length', $length);

            $insert_statement->execute();

        } catch (\PDOException $e){
            throw new \Exception("Error saving products: {$e->getMessage()}");
        }
    }

    public function deleteProduct(string $productId){
        try {
            $delete_statement = $this->conn->prepare("DELETE FROM products WHERE SKU = :product_id");
            $delete_statement->bindParam(':product_id', $productId);
            $delete_statement->execute();
            http_response_code(200);
        } catch (\PDOException $e){
            http_response_code(405);
            throw new \Exception("Error deleting products: {$e->getMessage()}");
        }
    }

}