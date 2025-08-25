<?php
class OrderItem {
    private $conn;
    private $table_name = "order_items";

    public $id;
    public $order_id;
    public $product_id;
    public $quantity;
    public $price;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Create order item
    function create() {
        $query = "INSERT INTO " . $this->table_name . " 
                SET order_id=:order_id, product_id=:product_id, quantity=:quantity, price=:price";

        $stmt = $this->conn->prepare($query);

        // Bind values
        $stmt->bindParam(":order_id", $this->order_id);
        $stmt->bindParam(":product_id", $this->product_id);
        $stmt->bindParam(":quantity", $this->quantity);
        $stmt->bindParam(":price", $this->price);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Read order items by order
    function readByOrder() {
        $query = "SELECT oi.*, p.name, p.image 
                FROM " . $this->table_name . " oi 
                JOIN products p ON oi.product_id = p.id 
                WHERE oi.order_id = :order_id";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':order_id', $this->order_id);
        $stmt->execute();
        return $stmt;
    }
}
?>