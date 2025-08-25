<?php
class Product {
    private $conn;
    private $table_name = "products";

    public $id;
    public $name;
    public $description;
    public $price;
    public $image;
    public $images;
    public $category;
    public $rating;
    public $reviews;
    public $in_stock;
    public $features;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Read all products
    function read() {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Read single product
    function readOne() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if($row) {
            $this->name = $row['name'];
            $this->description = $row['description'];
            $this->price = $row['price'];
            $this->image = $row['image'];
            $this->images = $row['images'];
            $this->category = $row['category'];
            $this->rating = $row['rating'];
            $this->reviews = $row['reviews'];
            $this->in_stock = $row['in_stock'];
            $this->features = $row['features'];
            return true;
        }
        return false;
    }

    // Create product
    function create() {
        $query = "INSERT INTO " . $this->table_name . " 
                SET name=:name, description=:description, price=:price, image=:image, 
                    images=:images, category=:category, rating=:rating, reviews=:reviews, 
                    in_stock=:in_stock, features=:features";

        $stmt = $this->conn->prepare($query);

        // Sanitize
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->price = htmlspecialchars(strip_tags($this->price));
        $this->image = htmlspecialchars(strip_tags($this->image));
        $this->category = htmlspecialchars(strip_tags($this->category));

        // Bind values
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":description", $this->description);
        $stmt->bindParam(":price", $this->price);
        $stmt->bindParam(":image", $this->image);
        $stmt->bindParam(":images", $this->images);
        $stmt->bindParam(":category", $this->category);
        $stmt->bindParam(":rating", $this->rating);
        $stmt->bindParam(":reviews", $this->reviews);
        $stmt->bindParam(":in_stock", $this->in_stock);
        $stmt->bindParam(":features", $this->features);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Update product
    function update() {
        $query = "UPDATE " . $this->table_name . " 
                SET name=:name, description=:description, price=:price, image=:image, 
                    images=:images, category=:category, rating=:rating, reviews=:reviews, 
                    in_stock=:in_stock, features=:features
                WHERE id=:id";

        $stmt = $this->conn->prepare($query);

        // Sanitize
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->price = htmlspecialchars(strip_tags($this->price));
        $this->image = htmlspecialchars(strip_tags($this->image));
        $this->category = htmlspecialchars(strip_tags($this->category));
        $this->id = htmlspecialchars(strip_tags($this->id));

        // Bind values
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":description", $this->description);
        $stmt->bindParam(":price", $this->price);
        $stmt->bindParam(":image", $this->image);
        $stmt->bindParam(":images", $this->images);
        $stmt->bindParam(":category", $this->category);
        $stmt->bindParam(":rating", $this->rating);
        $stmt->bindParam(":reviews", $this->reviews);
        $stmt->bindParam(":in_stock", $this->in_stock);
        $stmt->bindParam(":features", $this->features);
        $stmt->bindParam(":id", $this->id);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Delete product
    function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Search products
    function search($keywords) {
        $query = "SELECT * FROM " . $this->table_name . " 
                WHERE name LIKE ? OR description LIKE ? OR category LIKE ? 
                ORDER BY created_at DESC";

        $stmt = $this->conn->prepare($query);

        $keywords = htmlspecialchars(strip_tags($keywords));
        $keywords = "%{$keywords}%";

        $stmt->bindParam(1, $keywords);
        $stmt->bindParam(2, $keywords);
        $stmt->bindParam(3, $keywords);

        $stmt->execute();
        return $stmt;
    }
}
?>