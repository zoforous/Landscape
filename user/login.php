<?php
require_once '../includes/db.php';
require_once '../includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = trim($_POST['email']);
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && $user['password'] === $password) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];
        redirect('../index.php');
    } else {
        setFlash("Invalid login credentials.");
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login | GreenScape</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>
<body>
<header><h1>User Login</h1></header>

<main class="container">
    <p><?= getFlash(); ?></p>
    <form method="POST">
        <label>Email:</label>
        <input type="email" name="email" required>

        <label>Password:</label>
        <input type="password" name="password" required>

        <button type="submit">Login</button>
    </form>
    <p>No account yet? <a href="register.php">Register here</a>.</p>
</main>
</body>
</html>