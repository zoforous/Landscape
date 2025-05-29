<?php
require_once 'functions.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | GreenScape</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #2ecc71;
            --secondary-color: #27ae60;
            --dark-color: #2c3e50;
            --light-color: #ecf0f1;
            --danger-color: #e74c3c;
            --warning-color: #f1c40f;
            --info-color: #3498db;
            --success-color: #2ecc71;
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
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .site-header {
            background: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
        }

        .header-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0.5rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            text-decoration: none;
            color: var(--dark-color);
        }

        .brand i {
            font-size: 1.8rem;
            color: var(--primary-color);
        }

        .brand span {
            font-size: 1.5rem;
            font-weight: 600;
        }

        /* Admin Info Bar */
        .admin-info {
            display: flex;
            align-items: center;
            gap: 2rem;
            padding: 0.5rem 1rem;
            background: rgba(46, 204, 113, 0.1);
            border-radius: 50px;
        }

        .admin-info-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.9rem;
            color: var(--dark-color);
        }

        .admin-info-item i {
            color: var(--primary-color);
        }

        /* Navigation */
        nav {
            display: flex;
            align-items: center;
        }

        nav ul {
            display: flex;
            gap: 0.5rem;
            list-style: none;
        }

        nav a {
            text-decoration: none;
            color: var(--dark-color);
            padding: 0.5rem 1rem;
            border-radius: 50px;
            transition: var(--transition);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        nav a:hover {
            background: var(--primary-color);
            color: white;
            transform: translateY(-2px);
        }

        nav a.active {
            background: var(--primary-color);
            color: white;
        }

        /* Mobile Menu Button */
        .mobile-menu-btn {
            display: none;
            background: none;
            border: none;
            font-size: 1.5rem;
            color: var(--dark-color);
            cursor: pointer;
            padding: 0.5rem;
        }

        /* User Menu */
        .user-menu {
            position: relative;
        }

        .user-menu-btn {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            background: var(--light-color);
            border: none;
            border-radius: 50px;
            cursor: pointer;
            transition: var(--transition);
        }

        .user-menu-btn:hover {
            background: var(--primary-color);
            color: white;
        }

        .user-menu-dropdown {
            position: absolute;
            top: 100%;
            right: 0;
            background: white;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            padding: 0.5rem;
            margin-top: 0.5rem;
            min-width: 200px;
            display: none;
        }

        .user-menu-dropdown.active {
            display: block;
            animation: fadeIn 0.3s ease;
        }

        .user-menu-dropdown a {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem 1rem;
            color: var(--dark-color);
            text-decoration: none;
            transition: var(--transition);
            border-radius: 5px;
        }

        .user-menu-dropdown a:hover {
            background: var(--light-color);
            transform: translateX(5px);
        }

        /* Main Content Padding */
        .main-content {
            margin-top: 80px;
            padding: 2rem;
            flex-grow: 1;
        }

        /* Animations */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Responsive Design */
        @media (max-width: 1024px) {
            .admin-info {
                display: none;
            }
        }

        @media (max-width: 768px) {
            .mobile-menu-btn {
                display: block;
            }

            nav ul {
                display: none;
                position: absolute;
                top: 100%;
                left: 0;
                right: 0;
                background: white;
                flex-direction: column;
                padding: 1rem;
                box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            }

            nav ul.active {
                display: flex;
            }

            nav a {
                padding: 1rem;
                border-radius: 5px;
            }

            .header-container {
                padding: 0.5rem 1rem;
            }
        }
    </style>
</head>
<body>
<header class="site-header">
    <div class="header-container">
        <a href="/index.php" class="brand">
            <i class="fas fa-leaf"></i>
            <span>GreenScape</span>
        </a>

        <div class="admin-info">
            <div class="admin-info-item">
                <i class="fas fa-user"></i>
                <span><?= htmlspecialchars($username ?? 'zoforous') ?></span>
            </div>
            <div class="admin-info-item">
                <i class="fas fa-clock"></i>
                <span id="current-time">2025-05-29 05:56:38</span>
            </div>
        </div>

        <button class="mobile-menu-btn">
            <i class="fas fa-bars"></i>
        </button>

        <nav>
            <ul>
                <li><a href="/pages/home.php" class="<?= getCurrentPage() === 'home' ? 'active' : '' ?>">
                    <i class="fas fa-home"></i> Home
                </a></li>
                <li><a href="/pages/services.php" class="<?= getCurrentPage() === 'services' ? 'active' : '' ?>">
                    <i class="fas fa-tools"></i> Services
                </a></li>
                <li><a href="/pages/estimate.php" class="<?= getCurrentPage() === 'estimate' ? 'active' : '' ?>">
                    <i class="fas fa-calculator"></i> Estimator
                </a></li>
                <li><a href="/pages/contact.php" class="<?= getCurrentPage() === 'contact' ? 'active' : '' ?>">
                    <i class="fas fa-envelope"></i> Contact
                </a></li>
                <?php if (isLoggedIn()): ?>
                    <li class="user-menu">
                        <button class="user-menu-btn">
                            <i class="fas fa-user-circle"></i>
                            <span>Account</span>
                            <i class="fas fa-chevron-down"></i>
                        </button>
                        <div class="user-menu-dropdown">
                            <a href="/user/profile.php">
                                <i class="fas fa-user"></i> Profile
                            </a>
                            <a href="/admin/dashboard.php">
                                <i class="fas fa-tachometer-alt"></i> Dashboard
                            </a>
                            <a href="/user/settings.php">
                                <i class="fas fa-cog"></i> Settings
                            </a>
                            <a href="/user/logout.php" style="color: var(--danger-color);">
                                <i class="fas fa-sign-out-alt"></i> Logout
                            </a>
                        </div>
                    </li>
                <?php else: ?>
                    <li><a href="/user/login.php">
                        <i class="fas fa-sign-in-alt"></i> Login
                    </a></li>
                    <li><a href="/user/register.php">
                        <i class="fas fa-user-plus"></i> Register
                    </a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>
</header>

<main class="main-content">

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Mobile menu toggle
    const mobileMenuBtn = document.querySelector('.mobile-menu-btn');
    const navMenu = document.querySelector('nav ul');
    
    mobileMenuBtn?.addEventListener('click', () => {
        navMenu.classList.toggle('active');
        mobileMenuBtn.querySelector('i').classList.toggle('fa-bars');
        mobileMenuBtn.querySelector('i').classList.toggle('fa-times');
    });

    // User menu dropdown
    const userMenuBtn = document.querySelector('.user-menu-btn');
    const userMenuDropdown = document.querySelector('.user-menu-dropdown');
    
    userMenuBtn?.addEventListener('click', (e) => {
        e.stopPropagation();
        userMenuDropdown.classList.toggle('active');
    });

    // Close dropdown when clicking outside
    document.addEventListener('click', () => {
        userMenuDropdown?.classList.remove('active');
    });

    // Update time every second
    function updateTime() {
        const timeElement = document.getElementById('current-time');
        const now = new Date();
        const utcString = now.toISOString().slice(0, 19).replace('T', ' ');
        timeElement.textContent = utcString;
    }

    setInterval(updateTime, 1000);

    // Add hover animations for nav items
    const navLinks = document.querySelectorAll('nav a');
    navLinks.forEach(link => {
        link.addEventListener('mouseenter', () => {
            if (!link.classList.contains('active')) {
                link.style.transform = 'translateY(-2px)';
            }
        });
        link.addEventListener('mouseleave', () => {
            if (!link.classList.contains('active')) {
                link.style.transform = 'translateY(0)';
            }
        });
    });
});
</script>