<?php
session_start();
require 'db.php';
require 'userReg.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db = (new Database())->connect();
    $user = new User($db);

    $email = htmlspecialchars($_POST['email']);

    $userData = $user->login($email);
    if ($userData) {
        $_SESSION['user_id'] = $userData['id'];
        $_SESSION['first_name'] = $userData['first_name'];
        header("Location: welcome.php");
        exit;
    } else {
        $error = "No account found with this email!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="card">
            <div class="card-header bg-primary text-white text-center">
                <h3>Login</h3>
            </div>
            <div class="card-body">
                <?php if (!empty($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
                <form method="POST">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <button type="submit" class="btn btn-success">Login</button>
                </form>
                <p class="mt-3">Not registered? <a href="register.php">Login here</a>.</p>

            </div>
        </div>
    </div>
</body>
</html>
