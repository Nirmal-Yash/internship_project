<?php
include_once '../config/cors.php';
include_once '../config/database.php';
include_once '../models/Order.php';
include_once '../models/OrderItem.php';

$database = new Database();
$db = $database->getConnection();

$order = new Order($db);
$orderItem = new OrderItem($db);

$order->user_id = isset($_GET['user_id']) ? $_GET['user_id'] : die();

$stmt = $order->readByUser();
$num = $stmt->rowCount();

if($num > 0) {
    $orders_arr = array();
    $orders_arr["records"] = array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        // Get order items
        $orderItem->order_id = $id;
        $items_stmt = $orderItem->readByOrder();
        $items = array();

        while ($item_row = $items_stmt->fetch(PDO::FETCH_ASSOC)) {
            $items[] = array(
                "id" => $item_row['product_id'],
                "name" => $item_row['name'],
                "image" => $item_row['image'],
                "price" => floatval($item_row['price']),
                "quantity" => intval($item_row['quantity'])
            );
        }

        $order_item = array(
            "id" => $id,
            "userId" => $user_id,
            "total" => floatval($total),
            "status" => $status,
            "createdAt" => $created_at,
            "customerInfo" => array(
                "name" => $customer_name,
                "email" => $customer_email,
                "phone" => $customer_phone,
                "address" => $customer_address
            ),
            "items" => $items
        );

        array_push($orders_arr["records"], $order_item);
    }

    http_response_code(200);
    echo json_encode($orders_arr);
} else {
    http_response_code(404);
    echo json_encode(array("message" => "No orders found for this user."));
}
?>