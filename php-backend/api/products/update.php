<?php
include_once '../config/cors.php';
include_once '../config/database.php';
include_once '../models/Product.php';

$database = new Database();
$db = $database->getConnection();

$product = new Product($db);

// Get posted data
$data = json_decode(file_get_contents("php://input"));

if(!empty($data->id)) {
    $product->id = $data->id;
    $product->name = $data->name;
    $product->description = $data->description;
    $product->price = $data->price;
    $product->image = $data->image;
    $product->images = json_encode($data->images);
    $product->category = $data->category;
    $product->rating = $data->rating;
    $product->reviews = $data->reviews;
    $product->in_stock = $data->inStock;
    $product->features = json_encode($data->features);

    if($product->update()) {
        http_response_code(200);
        echo json_encode(array("message" => "Product updated successfully."));
    } else {
        http_response_code(503);
        echo json_encode(array("message" => "Unable to update product."));
    }
} else {
    http_response_code(400);
    echo json_encode(array("message" => "Product ID is required."));
}
?>