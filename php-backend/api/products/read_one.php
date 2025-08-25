<?php
include_once '../config/cors.php';
include_once '../config/database.php';
include_once '../models/Product.php';

$database = new Database();
$db = $database->getConnection();

$product = new Product($db);

$product->id = isset($_GET['id']) ? $_GET['id'] : die();

if($product->readOne()) {
    $product_arr = array(
        "id" => $product->id,
        "name" => $product->name,
        "description" => $product->description,
        "price" => floatval($product->price),
        "image" => $product->image,
        "images" => json_decode($product->images),
        "category" => $product->category,
        "rating" => floatval($product->rating),
        "reviews" => intval($product->reviews),
        "inStock" => boolval($product->in_stock),
        "features" => json_decode($product->features)
    );

    http_response_code(200);
    echo json_encode($product_arr);
} else {
    http_response_code(404);
    echo json_encode(array("message" => "Product not found."));
}
?>