<?php
require_once '../includes/db.php';
require_once '../includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = trim($_POST['email']);
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ? AND role = 'admin'");
    $stmt->execute([$email]);
    $admin = $stmt->fetch();

    if ($admin && $admin['password'] === $password) {
        $_SESSION['admin_id'] = $admin['id'];
        $_SESSION['admin_username'] = $admin['username'];
        redirect('dashboard.php');
    } else {
        setFlash("Invalid admin credentials.");
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login | GreenScape</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #2ecc71;
            --secondary-color: #27ae60;
            --dark-color: #2c3e50;
            --light-color: #ecf0f1;
            --danger-color: #e74c3c;
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
            background: linear-gradient(135deg, #27ae60 0%, #2ecc71 100%);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            position: relative;
        }

        .time-display {
            position: fixed;
            top: 1rem;
            right: 1rem;
            background: rgba(255, 255, 255, 0.1);
            padding: 0.5rem 1rem;
            border-radius: 50px;
            color: white;
            backdrop-filter: blur(5px);
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .container {
            width: 90%;
            max-width: 400px;
            margin: 2rem auto;
            padding: 2rem 20px;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .back-button {
            position: fixed;
            top: 1rem;
            left: 1rem;
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem 1.5rem;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50px;
            backdrop-filter: blur(5px);
            transition: var(--transition);
        }

        .back-button:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: translateX(-5px);
        }

        /* Header Styles */
        header {
            text-align: center;
            padding: 3rem 0;
            color: white;
        }

        header h1 {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            animation: fadeInDown 1s ease;
        }

        /* Login Form */
        .login-card {
            background: white;
            border-radius: 15px;
            padding: 2rem;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            animation: fadeInUp 1s ease;
        }

        .form-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .form-header i {
            font-size: 3rem;
            color: var(--primary-color);
            margin-bottom: 1rem;
        }

        .form-header h2 {
            color: var(--dark-color);
            font-size: 1.5rem;
        }

        .flash-message {
            padding: 1rem;
            border-radius: 10px;
            margin-bottom: 1.5rem;
            text-align: center;
            animation: shake 0.5s ease;
            background: rgba(231, 76, 60, 0.1);
            color: var(--danger-color);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
            position: relative;
        }

        .form-group i {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #999;
            transition: var(--transition);
        }

        label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: var(--dark-color);
        }

        input {
            width: 100%;
            padding: 1rem 1rem 1rem 3rem;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            font-size: 1rem;
            transition: var(--transition);
            outline: none;
        }

        input:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(46, 204, 113, 0.1);
        }

        input:focus + i {
            color: var(--primary-color);
        }

        .submit-button {
            background: var(--primary-color);
            color: white;
            border: none;
            padding: 1rem;
            font-size: 1.1rem;
            border-radius: 10px;
            cursor: pointer;
            width: 100%;
            transition: var(--transition);
            font-weight: 500;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .submit-button:hover {
            background: var(--secondary-color);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(46, 204, 113, 0.3);
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

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-10px); }
            75% { transform: translateX(10px); }
        }

        /* Responsive Design */
        @media (max-width: 480px) {
            .container {
                width: 95%;
                padding: 1rem;
            }

            header h1 {
                font-size: 2rem;
            }

            .back-button {
                top: 1rem;
                left: 1rem;
                padding: 0.5rem 1rem;
            }

            .login-card {
                padding: 1.5rem;
            }
        }
    </style>
</head>
<body>

<a href="../index.php" class="back-button">
    <i class="fas fa-arrow-left"></i> Back to Home
</a>

<div class="time-display">
    <i class="fas fa-clock"></i>
    <span id="current-time">2025-05-29 06:01:33</span>
</div>

<header>
    <h1>Admin Login</h1>
    <p>Access the GreenScape admin dashboard</p>
</header>

<main class="container">
    <div class="login-card">
        <div class="form-header">
            <i class="fas fa-user-shield"></i>
            <h2>Admin Authentication</h2>
        </div>

        <?php if ($flash = getFlash()): ?>
            <div class="flash-message">
                <i class="fas fa-exclamation-circle"></i>
                <?= $flash ?>
            </div>
        <?php endif; ?>

        <form method="POST" id="loginForm">
            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" 
                       name="email" 
                       id="email" 
                       required 
                       autocomplete="email"
                       placeholder="Enter your admin email">
                <i class="fas fa-envelope"></i>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" 
                       name="password" 
                       id="password" 
                       required
                       placeholder="Enter your password">
                <i class="fas fa-lock"></i>
            </div>

            <button type="submit" class="submit-button">
                <i class="fas fa-sign-in-alt"></i> Login to Dashboard
            </button>
        </form>
    </div>
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Update time every second
    function updateTime() {
        const timeElement = document.getElementById('current-time');
        const now = new Date();
        const utcString = now.toISOString().slice(0, 19).replace('T', ' ');
        timeElement.textContent = utcString;
    }

    setInterval(updateTime, 1000);

    // Add form submission animation
    const form = document.getElementById('loginForm');
    form.addEventListener('submit', function(e) {
        const button = form.querySelector('.submit-button');
        button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Authenticating...';
    });

    // Add input focus effects
    const inputs = form.querySelectorAll('input');
    inputs.forEach(input => {
        const icon = input.nextElementSibling;

        input.addEventListener('focus', function() {
            this.parentElement.style.transform = 'translateX(5px)';
            icon.style.color = 'var(--primary-color)';
        });

        input.addEventListener('blur', function() {
            this.parentElement.style.transform = 'translateX(0)';
            if (!this.value) {
                icon.style.color = '#999';
            }
        });
    });
});
</script>

</body>
</html>