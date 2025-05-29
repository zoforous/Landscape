<?php
require_once '../includes/db.php';
require_once '../includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email    = trim($_POST['email']);
    $password = $_POST['password'];

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    try {
        $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $stmt->execute([$username, $email, $password]);
        setFlash("Registration successful. Please log in.");
        redirect('login.php');
    } catch (PDOException $e) {
        setFlash("Error: " . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register | GreenScape</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>
<body>
<header><h1>User Registration</h1></header>

<main class="container">
    <p><?= getFlash(); ?></p>
    <form method="POST">
        <label>Username:</label>
        <input type="text" name="username" required>

        <label>Email:</label>
        <input type="email" name="email" required>

        <label>Password:</label>
        <input type="password" name="password" required>

        <button type="submit">Register</button>
    </form>
    <p>Already have an account? <a href="login.php">Login here</a>.</p>
</main>
</body>
</html>