<?php
require_once '../includes/db.php';
require_once '../includes/functions.php';
require_once '../admin/includes/auth.php';
requireUser();

if (!isLoggedIn()) {
    setFlash("You must be logged in to view your profile.");
    redirect('login.php');
}

$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Profile</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>
<body>
<header><h1>My Profile</h1></header>

<main class="container">
    <p><strong>Username:</strong> <?= e($user['username']); ?></p>
    <p><strong>Email:</strong> <?= e($user['email']); ?></p>
    <p><strong>Role:</strong> <?= e($user['role']); ?></p>
    <p><a href="../index.php">Back to Home</a> | <a href="logout.php">Logout</a></p>
</main>
</body>
</html>