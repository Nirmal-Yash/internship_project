<?php
include_once '../config/cors.php';
include_once '../config/database.php';
include_once '../models/Product.php';

$database = new Database();
$db = $database->getConnection();

$product = new Product($db);

// Get posted data
$data = json_decode(file_get_contents("php://input"));

if(!empty($data->name) && !empty($data->price)) {
    $product->name = $data->name;
    $product->description = $data->description;
    $product->price = $data->price;
    $product->image = $data->image;
    $product->images = json_encode($data->images);
    $product->category = $data->category;
    $product->rating = isset($data->rating) ? $data->rating : 0;
    $product->reviews = isset($data->reviews) ? $data->reviews : 0;
    $product->in_stock = isset($data->inStock) ? $data->inStock : true;
    $product->features = json_encode($data->features);

    if($product->create()) {
        http_response_code(201);
        echo json_encode(array("message" => "Product created successfully."));
    } else {
        http_response_code(503);
        echo json_encode(array("message" => "Unable to create product."));
    }
} else {
    http_response_code(400);
    echo json_encode(array("message" => "Product name and price are required."));
}
?>