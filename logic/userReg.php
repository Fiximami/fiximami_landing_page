<?php
class User {
    private $conn;
    private $table = 'users';

    public function __construct($db) {
        $this->conn = $db;
    }

    public function register($name, $email, $phone, $role) {
        $query = "INSERT INTO " . $this->table . " (name, email, phone, role) 
                  VALUES (:name, :email, :phone, :role)";
        $stmt = $this->conn->prepare($query);

        // Bind parameters
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':role', $role);

        return $stmt->execute();
    }
}
?>
