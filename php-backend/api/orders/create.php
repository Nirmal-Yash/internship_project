<?php
include_once '../config/cors.php';
include_once '../config/database.php';
include_once '../models/Order.php';
include_once '../models/OrderItem.php';

$database = new Database();
$db = $database->getConnection();

$order = new Order($db);
$orderItem = new OrderItem($db);

// Get posted data
$data = json_decode(file_get_contents("php://input"));

if(!empty($data->items) && !empty($data->total) && !empty($data->customerInfo)) {
    // Start transaction
    $db->beginTransaction();

    try {
        // Create order
        $order->user_id = isset($data->userId) ? $data->userId : null;
        $order->total = $data->total;
        $order->status = 'pending';
        $order->customer_name = $data->customerInfo->name;
        $order->customer_email = $data->customerInfo->email;
        $order->customer_phone = $data->customerInfo->phone;
        $order->customer_address = $data->customerInfo->address;

        if($order->create()) {
            // Create order items
            foreach($data->items as $item) {
                $orderItem->order_id = $order->id;
                $orderItem->product_id = $item->id;
                $orderItem->quantity = $item->quantity;
                $orderItem->price = $item->price;

                if(!$orderItem->create()) {
                    throw new Exception("Failed to create order item");
                }
            }

            // Commit transaction
            $db->commit();

            http_response_code(201);
            echo json_encode(array(
                "message" => "Order created successfully.",
                "order_id" => $order->id
            ));
        } else {
            throw new Exception("Failed to create order");
        }
    } catch(Exception $e) {
        // Rollback transaction
        $db->rollback();
        
        http_response_code(503);
        echo json_encode(array("message" => "Unable to create order."));
    }
} else {
    http_response_code(400);
    echo json_encode(array("message" => "Order items, total, and customer info are required."));
}
?>