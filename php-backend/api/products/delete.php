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

    if($product->delete()) {
        http_response_code(200);
        echo json_encode(array("message" => "Product deleted successfully."));
    } else {
        http_response_code(503);
        echo json_encode(array("message" => "Unable to delete product."));
    }
} else {
    http_response_code(400);
    echo json_encode(array("message" => "Product ID is required."));
}
?>