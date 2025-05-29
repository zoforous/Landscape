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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | GreenScape</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #2ecc71;
            --secondary-color: #27ae60;
            --dark-color: #2c3e50;
            --light-color: #ecf0f1;
            --error-color: #e74c3c;
            --success-color: #27ae60;
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
            background: linear-gradient(135deg, #2ecc71 0%, #27ae60 100%);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .container {
            width: 90%;
            max-width: 400px;
            margin: 0 auto;
            padding: 2rem 20px;
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

        .back-button {
            position: absolute;
            top: 2rem;
            left: 2rem;
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

        input[type="email"],
        input[type="password"] {
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

        .flash-message {
            padding: 1rem;
            border-radius: 10px;
            margin-bottom: 1.5rem;
            background: rgba(231, 76, 60, 0.1);
            color: var(--error-color);
            text-align: center;
            animation: shake 0.5s ease;
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
        }

        .submit-button:hover {
            background: var(--secondary-color);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(46, 204, 113, 0.3);
        }

        .register-link {
            text-align: center;
            color: #666;
        }

        .register-link a {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 500;
            transition: var(--transition);
        }

        .register-link a:hover {
            color: var(--secondary-color);
            text-decoration: underline;
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

<header>
    <h1>Welcome Back</h1>
</header>

<main class="container">
    <div class="login-card">
        <div class="form-header">
            <i class="fas fa-user-circle"></i>
            <h2>Login to Your Account</h2>
        </div>

        <?php if ($flash = getFlash()): ?>
            <div class="flash-message">
                <i class="fas fa-exclamation-circle"></i> <?= $flash ?>
            </div>
        <?php endif; ?>

        <form method="POST" id="loginForm">
            <div class="form-group">
                <input type="email" 
                       name="email" 
                       id="email" 
                       required 
                       placeholder="Enter your email">
                <i class="fas fa-envelope"></i>
            </div>

            <div class="form-group">
                <input type="password" 
                       name="password" 
                       id="password" 
                       required 
                       placeholder="Enter your password">
                <i class="fas fa-lock"></i>
            </div>

            <button type="submit" class="submit-button">
                <i class="fas fa-sign-in-alt"></i> Login
            </button>

            <div class="register-link">
                <p>No account yet? <a href="register.php">Register here</a></p>
            </div>
        </form>
    </div>
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('loginForm');
    const inputs = form.querySelectorAll('input');

    // Add form submission animation
    form.addEventListener('submit', function(e) {
        const button = form.querySelector('.submit-button');
        button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Logging in...';
    });

    // Add input focus effects
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