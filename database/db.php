<?php
class Database {
    private $host = 'orion.galaxysecured.net'; // Change if your database is hosted elsewhere
    private $db_name = 'fiximami4_WaitList'; // Replace with your database name
    private $artisan_username = 'artisan_user'; // Username for artisans
    private $user_username = 'user_client'; // Username for regular users
    private $password = ''; // Replace with your database password
    private $conn;

    public function connect($role) {
        $this->conn = null;
        try {
            // Determine which user to connect with based on role
            $username = ($role === 'artisan') ? $this->artisan_username : $this->user_username;
        
            $this->conn = new PDO(
                "mysql:host=" . $this->host . ";dbname=" . $this->db_name,
                $username,
                $this->password
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die(json_encode(['status' => 'error', 'message' => 'Database connection failed: ' . $e->getMessage()]));
        }

        return $this->conn;
    }
}
?>
