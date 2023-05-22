<?php

// PHP VERSION 7.4^
// MYSQL VERSION 8.0^

namespace index;

use controllers\ProductController;
use models\Book;
use models\Dvd;
use models\Furniture;
use PDO;

require_once 'api/models/Dvd.php';
require_once 'api/models/Furniture.php';
require_once 'api/models/Book.php';
require_once 'api/controllers/ProductController.php';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

// Autoloading classes
spl_autoload_register(function ($class) {
    $class = str_replace('\\', '/', $class);
    require_once "$class.php";
});

// Init database
$servername = "us-cdbr-east-06.cleardb.net";
$username = "b5d50a1d05cef8";
$password = 'a97c1d45';
$database = "heroku_c97f13ded679cd5";

$conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$productController = new ProductController($conn);

// ENDPOINT (GET) '/'
if ($_SERVER['REQUEST_METHOD'] === 'GET' && $_SERVER['REQUEST_URI'] == '/') {
    try {
        $results = $productController->getAllProducts();
        echo json_encode($results);
    } catch (\PDOException $e) {
        echo "Error in connection: {$e->getMessage()}";
    }
}

// ENDPOINT (POST) '/'
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    $product = null;

    if (!empty($data['SKU']) && !empty($data['name']) && !empty($data['price'])) {
        if (!empty($data['weight'])) {
            $product = new Book($data['SKU'], $data['name'], $data['price'], $data['weight']);
        } else if (!empty($data['size'])) {
            $product = new Dvd($data['SKU'], $data['name'], $data['price'], $data['size']);
        } else if (!empty($data['height']) && !empty($data['width']) && !empty($data['length'])) {
            $product = new Furniture($data['SKU'], $data['name'], $data['price'], $data['height'], $data['width'], $data['length']);
        }

        if ($product !== null) {
            $productController->saveProduct($product);
            echo json_encode("Product saved.");
        } else {
            http_response_code(400);
            echo json_encode("Invalid product data");
        }
    } else {
        http_response_code(400);
        echo json_encode("Invalid input");
    }
}

// ENDPOINT (DELETE) '/${id}'
if ($_SERVER['REQUEST_METHOD'] === 'DELETE'){
    $id = $_GET['id'];

    try {
        $productController->deleteProduct($id);
        echo json_encode("{$id} deleted.");
    } catch (\PDOException $e){
        echo "Error deleting: {$e->getMessage()}";
    }
}

?>