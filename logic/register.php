<?php
require '../database/db.php'; // Database connection class
// User class for registration
class User {
    private $conn;
    private $table = "users";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function register($name, $phone, $email, $role) {
        // Check if email already exists
        $query = "SELECT * FROM " . $this->table . " WHERE email = :email";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":email", $email);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return ["status" => "error", "message" => "Email is already registered."];
        }

        // Insert new user
        $query = "INSERT INTO " . $this->table . " (name, phone, email, role) VALUES (:name, :phone, :email, :role)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":name", $name);
        $stmt->bindParam(":phone", $phone);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":role", $role);

        if ($stmt->execute()) {
            return ["status" => "success", "message" => "Registration successful!"];
        } else {
            return ["status" => "error", "message" => "Registration failed. Please try again."];
        }
    }
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate input
    $name = htmlspecialchars(strip_tags($_POST['name']));
    $phone = htmlspecialchars(strip_tags($_POST['phone']));
    $email = htmlspecialchars(strip_tags($_POST['email']));
    $role = htmlspecialchars(strip_tags($_POST['role']));

    if (empty($name) || empty($phone) || empty($email) || empty($role)) {
        echo json_encode(["status" => "error", "message" => "All fields are required."]);
        exit;
    }

    // Database connection
    $database = new Database();
    $db = $database->connect();

    // User registration
    $user = new User($db);
    $response = $user->register($name, $phone, $email, $role);

    // Return JSON response
    echo json_encode($response);
}
?>
