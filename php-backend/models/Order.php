<?php
class Order {
    private $conn;
    private $table_name = "orders";

    public $id;
    public $user_id;
    public $total;
    public $status;
    public $customer_name;
    public $customer_email;
    public $customer_phone;
    public $customer_address;
    public $created_at;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Create order
    function create() {
        $query = "INSERT INTO " . $this->table_name . " 
                SET user_id=:user_id, total=:total, status=:status, 
                    customer_name=:customer_name, customer_email=:customer_email, 
                    customer_phone=:customer_phone, customer_address=:customer_address";

        $stmt = $this->conn->prepare($query);

        // Sanitize
        $this->customer_name = htmlspecialchars(strip_tags($this->customer_name));
        $this->customer_email = htmlspecialchars(strip_tags($this->customer_email));
        $this->customer_phone = htmlspecialchars(strip_tags($this->customer_phone));
        $this->customer_address = htmlspecialchars(strip_tags($this->customer_address));

        // Bind values
        $stmt->bindParam(":user_id", $this->user_id);
        $stmt->bindParam(":total", $this->total);
        $stmt->bindParam(":status", $this->status);
        $stmt->bindParam(":customer_name", $this->customer_name);
        $stmt->bindParam(":customer_email", $this->customer_email);
        $stmt->bindParam(":customer_phone", $this->customer_phone);
        $stmt->bindParam(":customer_address", $this->customer_address);

        if($stmt->execute()) {
            $this->id = $this->conn->lastInsertId();
            return true;
        }
        return false;
    }

    // Read all orders
    function read() {
        $query = "SELECT o.*, u.name as user_name 
                FROM " . $this->table_name . " o 
                LEFT JOIN users u ON o.user_id = u.id 
                ORDER BY o.created_at DESC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Read orders by user
    function readByUser() {
        $query = "SELECT * FROM " . $this->table_name . " 
                WHERE user_id = :user_id 
                ORDER BY created_at DESC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $this->user_id);
        $stmt->execute();
        return $stmt;
    }

    // Read single order
    function readOne() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if($row) {
            $this->user_id = $row['user_id'];
            $this->total = $row['total'];
            $this->status = $row['status'];
            $this->customer_name = $row['customer_name'];
            $this->customer_email = $row['customer_email'];
            $this->customer_phone = $row['customer_phone'];
            $this->customer_address = $row['customer_address'];
            $this->created_at = $row['created_at'];
            return true;
        }
        return false;
    }

    // Update order status
    function updateStatus() {
        $query = "UPDATE " . $this->table_name . " SET status=:status WHERE id=:id";
        $stmt = $this->conn->prepare($query);

        $this->status = htmlspecialchars(strip_tags($this->status));
        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(":status", $this->status);
        $stmt->bindParam(":id", $this->id);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Get order items
    function getOrderItems() {
        $query = "SELECT oi.*, p.name, p.image 
                FROM order_items oi 
                JOIN products p ON oi.product_id = p.id 
                WHERE oi.order_id = :order_id";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':order_id', $this->id);
        $stmt->execute();
        return $stmt;
    }
}
?>