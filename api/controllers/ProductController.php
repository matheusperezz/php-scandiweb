<?php

namespace controllers;

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
        $sql = "SELECT * FROM products";

        try {
            $stmt = $this->conn->query($sql);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            throw new \Exception("Error retrieving products: {$e->getMessage()}");
        }
    }

    public function saveProduct($product)
    {
        $tableName = 'products';
        $properties = get_object_vars($product);
        $keys = array_keys($properties);
        $columns = implode(', ', $keys);
        $values = ':' . implode(', :', $keys);

        try {
            $insert_statement = $this->conn->prepare("INSERT INTO $tableName ($columns) VALUES ($values)");
            foreach ($properties as $key => $value) {
                $insert_statement->bindValue(":$key", $value);
            }
            $insert_statement->execute();
        } catch (\PDOException $e) {
            throw new \Exception("Error saving products: {$e->getMessage()}");
        }
    }

    public function deleteProduct(string $productId)
    {
        try {
            $delete_statement = $this->conn->prepare("DELETE FROM products WHERE SKU = :product_id");
            $delete_statement->bindParam(':product_id', $productId);
            $delete_statement->execute();
        } catch (\PDOException $e) {
            throw new \Exception("Error deleting products: {$e->getMessage()}");
        }
    }
}

?>