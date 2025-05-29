<?php
require_once '../includes/db.php';
require_once '../includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $pdo->prepare("INSERT INTO contacts (name, email, phone, message) VALUES (?, ?, ?, ?)");
    $stmt->execute([
        $_POST['name'],
        $_POST['email'],
        $_POST['phone'],
        $_POST['message']
    ]);
    redirect('thank-you.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Contact Us</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>
<body>

<header><h1>Contact Us</h1></header>

<main class="container">
    <form method="POST">
        <label>Name:</label>
        <input type="text" name="name" required>

        <label>Email:</label>
        <input type="email" name="email" required>

        <label>Phone:</label>
        <input type="tel" name="phone">

        <label>Message:</label>
        <textarea name="message" required></textarea>

        <button type="submit">Send</button>
    </form>
</main>

</body>
</html>