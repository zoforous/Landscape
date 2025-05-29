<?php
require_once '../includes/functions.php';
require_once 'includes/auth.php';

requireAdmin();

if (!isset($_SESSION['admin_id'])) {
    setFlash("Admin access required.");
    redirect('login.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>
<body>
<header><h1>Admin Dashboard</h1></header>

<main class="container">
    <p>Welcome, <?= e($_SESSION['admin_username']); ?>!</p>
    <ul>
        <li><a href="manage-contacts.php">Manage Contact Submissions</a></li>
        <li><a href="manage-estimates.php">Manage Cost Estimates</a></li>
        <li><a href="logout.php">Logout</a></li>
    </ul>
</main>
</body>
</html>