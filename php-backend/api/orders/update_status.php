<?php
include_once '../config/cors.php';
include_once '../config/database.php';
include_once '../models/Order.php';

$database = new Database();
$db = $database->getConnection();

$order = new Order($db);

// Get posted data
$data = json_decode(file_get_contents("php://input"));

if(!empty($data->id) && !empty($data->status)) {
    $order->id = $data->id;
    $order->status = $data->status;

    if($order->updateStatus()) {
        http_response_code(200);
        echo json_encode(array("message" => "Order status updated successfully."));
    } else {
        http_response_code(503);
        echo json_encode(array("message" => "Unable to update order status."));
    }
} else {
    http_response_code(400);
    echo json_encode(array("message" => "Order ID and status are required."));
}
?>