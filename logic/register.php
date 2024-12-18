<?php
require '../database/db.php'; // Database connection class
require '../logic/userReg.php'; // User registration class

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db = (new Database())->connect();
    $user = new User($db);

    // Sanitize and validate user inputs
    $name = htmlspecialchars(trim($_POST['name']));
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $phone = htmlspecialchars(trim($_POST['phone']));
    $role = htmlspecialchars(trim($_POST['role']));

    // Check for valid email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid email format!']);
        exit;
    }

    // Attempt to register the user
    if ($user->register($name, $email, $phone, $role)) {
        echo json_encode(['status' => 'success', 'message' => 'Registration successful!']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error registering user. Try again later!']);
    }

    exit; // Ensure no further output is sent
}
?>
