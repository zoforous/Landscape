<?php
require_once 'functions.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>GreenScape Landscaping</title>
    <link rel="stylesheet" href="/assets/css/styles.css">
</head>
<body>
<header class="site-header">
    <h1><a href="/index.php">GreenScape</a></h1>
    <nav>
        <ul>
            <li><a href="/pages/home.php">Home</a></li>
            <li><a href="/pages/services.php">Services</a></li>
            <li><a href="/pages/estimate.php">Estimator</a></li>
            <li><a href="/pages/contact.php">Contact</a></li>
            <?php if (isLoggedIn()): ?>
                <li><a href="/user/profile.php">Profile</a></li>
                <li><a href="/user/logout.php">Logout</a></li>
            <?php else: ?>
                <li><a href="/user/login.php">Login</a></li>
                <li><a href="/user/register.php">Register</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</header>

<main class="main-content">