<?php
require_once 'includes/functions.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GreenScape Landscaping Services</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #2ecc71;
            --secondary-color: #27ae60;
            --dark-color: #2c3e50;
            --light-color: #ecf0f1;
            --transition: all 0.3s ease;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            line-height: 1.6;
            color: var(--dark-color);
        }

        .container {
            width: 90%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        /* Header Styles */
        header {
            background: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
        }

        header .container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 20px;
        }

        header h1 {
            color: var(--primary-color);
            font-size: 1.8rem;
            font-weight: 700;
        }

        nav ul {
            display: flex;
            gap: 2rem;
            list-style: none;
        }

        nav a {
            text-decoration: none;
            color: var(--dark-color);
            font-weight: 500;
            transition: var(--transition);
            padding: 0.5rem 1rem;
            border-radius: 5px;
        }

        nav a:hover {
            color: var(--primary-color);
            background: rgba(46, 204, 113, 0.1);
        }

        .admin-login {
            position: absolute;
            top: 1rem;
            right: 1rem;
            text-decoration: none;
            color: var(--dark-color);
            font-size: 0.9rem;
            opacity: 0.7;
            transition: var(--transition);
        }

        .admin-login:hover {
            opacity: 1;
        }

        /* Hero Section */
        .hero {
            background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), 
                        url('https://images.unsplash.com/photo-1558904541-efa843a96f01?auto=format&fit=crop&w=1600&q=80');
            background-size: cover;
            background-position: center;
            height: 100vh;
            display: flex;
            align-items: center;
            text-align: center;
            color: white;
            margin-top: 70px;
        }

        .hero h2 {
            font-size: 3.5rem;
            margin-bottom: 1rem;
            animation: fadeInDown 1s ease;
        }

        .hero p {
            font-size: 1.2rem;
            margin-bottom: 2rem;
            animation: fadeInUp 1s ease;
        }

        .btn {
            display: inline-block;
            padding: 1rem 2rem;
            background: var(--primary-color);
            color: white;
            text-decoration: none;
            border-radius: 50px;
            transition: var(--transition);
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 1px;
            animation: fadeIn 1.5s ease;
        }

        .btn:hover {
            background: var(--secondary-color);
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(46, 204, 113, 0.3);
        }

        /* Features Section */
        .features {
            padding: 5rem 0;
            background: var(--light-color);
        }

        .features h3 {
            text-align: center;
            font-size: 2.5rem;
            margin-bottom: 3rem;
            color: var(--dark-color);
        }

        .feature-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
        }

        .feature {
            background: white;
            padding: 2rem;
            border-radius: 10px;
            text-align: center;
            transition: var(--transition);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .feature:hover {
            transform: translateY(-10px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.1);
        }

        .feature i {
            font-size: 2.5rem;
            color: var(--primary-color);
            margin-bottom: 1rem;
        }

        .feature h4 {
            font-size: 1.5rem;
            margin-bottom: 1rem;
            color: var(--dark-color);
        }

        .feature p {
            color: #666;
        }

        /* Footer */
        footer {
            background: var(--dark-color);
            color: white;
            padding: 2rem 0;
            text-align: center;
        }

        /* Animations */
        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            header .container {
                flex-direction: column;
                text-align: center;
            }

            nav ul {
                flex-direction: column;
                gap: 1rem;
                margin-top: 1rem;
            }

            .hero h2 {
                font-size: 2.5rem;
            }

            .feature-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <header>
        <div class="container">
            <h1>GreenScape Landscaping</h1>
            <nav>
                <ul>
                    <li><a href="index.php"><i class="fas fa-home"></i> Home</a></li>
                    <li><a href="pages/services.php"><i class="fas fa-leaf"></i> Services</a></li>
                    <li><a href="pages/estimate.php"><i class="fas fa-calculator"></i> Get Estimate</a></li>
                    <li><a href="pages/contact.php"><i class="fas fa-envelope"></i> Contact</a></li>
                    <?php if (isLoggedIn()): ?>
                        <li><a href="user/profile.php"><i class="fas fa-user"></i> My Profile</a></li>
                        <li><a href="user/logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
                    <?php else: ?>
                        <li><a href="user/login.php"><i class="fas fa-sign-in-alt"></i> Login</a></li>
                        <li><a href="user/register.php"><i class="fas fa-user-plus"></i> Register</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
        <a href="admin/login.php" class="admin-login"><i class="fas fa-lock"></i> Admin</a>
    </header>

    <section class="hero">
        <div class="container">
            <h2>Transform Your Outdoor Space</h2>
            <p>Professional landscaping solutions tailored to your needs. Get a free estimate today!</p>
            <a href="pages/estimate.php" class="btn">
                <i class="fas fa-leaf"></i> Estimate Your Project
            </a>
        </div>
    </section>

    <section class="features">
        <div class="container">
            <h3>Why Choose Us?</h3>
            <div class="feature-grid">
                <div class="feature">
                    <i class="fas fa-pencil-ruler"></i>
                    <h4>Custom Designs</h4>
                    <p>Unique landscaping solutions crafted for each client.</p>
                </div>
                <div class="feature">
                    <i class="fas fa-dollar-sign"></i>
                    <h4>Affordable Pricing</h4>
                    <p>Get a cost-effective plan that suits your budget.</p>
                </div>
                <div class="feature">
                    <i class="fas fa-users"></i>
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

    <script>
        // Add smooth scrolling
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });

        // Add header scroll effect
        window.addEventListener('scroll', function() {
            const header = document.querySelector('header');
            if (window.scrollY > 50) {
                header.style.background = 'rgba(255, 255, 255, 0.95)';
            } else {
                header.style.background = 'white';
            }
        });
    </script>
</body>
</html>