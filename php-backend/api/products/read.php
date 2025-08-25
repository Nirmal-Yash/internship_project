<?php
include_once '../config/cors.php';
include_once '../config/database.php';
include_once '../models/Product.php';

$database = new Database();
$db = $database->getConnection();

$product = new Product($db);

$stmt = $product->read();
$num = $stmt->rowCount();

if($num > 0) {
    $products_arr = array();
    $products_arr["records"] = array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $product_item = array(
            "id" => $id,
            "name" => $name,
            "description" => $description,
            "price" => floatval($price),
            "image" => $image,
            "images" => json_decode($images),
            "category" => $category,
            "rating" => floatval($rating),
            "reviews" => intval($reviews),
            "inStock" => boolval($in_stock),
            "features" => json_decode($features)
        );

        array_push($products_arr["records"], $product_item);
    }

    http_response_code(200);
    echo json_encode($products_arr);
} else {
    http_response_code(404);
    echo json_encode(array("message" => "No products found."));
}
?>