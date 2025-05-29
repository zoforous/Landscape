<?php
require_once 'includes/functions.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GreenScape Landscaping Services</title>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>

    <header>
        <div class="container">
            <h1>GreenScape Landscaping</h1>
            <nav>
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="pages/services.php">Services</a></li>
                    <li><a href="pages/estimate.php">Get Estimate</a></li>
                    <li><a href="pages/contact.php">Contact</a></li>
                    <?php if (isLoggedIn()): ?>
                        <li><a href="user/profile.php">My Profile</a></li>
                        <li><a href="user/logout.php">Logout</a></li>
                    <?php else: ?>
                        <li><a href="user/login.php">Login</a></li>
                        <li><a href="user/register.php">Register</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
        <a href="admin/login.php">Admin Login</a>
    </header>

    <section class="hero">
        <div class="container">
            <h2>Transform Your Outdoor Space</h2>
            <p>Professional landscaping solutions tailored to your needs. Get a free estimate today!</p>
            <a href="pages/estimate.php" class="btn">Estimate Your Project</a>
        </div>
    </section>

    <section class="features">
        <div class="container">
            <h3>Why Choose Us?</h3>
            <div class="feature-grid">
                <div class="feature">
                    <h4>Custom Designs</h4>
                    <p>Unique landscaping solutions crafted for each client.</p>
                </div>
                <div class="feature">
                    <h4>Affordable Pricing</h4>
                    <p>Get a cost-effective plan that suits your budget.</p>
                </div>
                <div class="feature">
                    <h4>Experienced Team</h4>
                    <p>Professionals with over a decade of experience in landscaping.</p>
                </div>
            </div>
        </div>
    </section>

    <footer>
        <div class="container">
            <p>&copy; <?= date('Y') ?> GreenScape Landscaping. All rights reserved.</p>
        </div>
    </footer>

</body>
</html>
