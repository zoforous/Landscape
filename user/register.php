<?php
require_once '../includes/db.php';
require_once '../includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email    = trim($_POST['email']);
    $password = $_POST['password'];

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    try {
        $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $stmt->execute([$username, $email, $password]);
        setFlash("Registration successful. Please log in.");
        redirect('login.php');
    } catch (PDOException $e) {
        setFlash("Error: " . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | GreenScape</title>
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
            background: linear-gradient(135deg, #27ae60 0%, #2ecc71 100%);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .container {
            width: 90%;
            max-width: 450px;
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

        header p {
            font-size: 1.1rem;
            opacity: 0.9;
            max-width: 600px;
            margin: 0 auto;
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

        /* Registration Form */
        .register-card {
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

        .password-strength {
            margin-top: 0.5rem;
            font-size: 0.85rem;
            color: #666;
        }

        .password-strength span {
            display: inline-block;
            width: 25%;
            height: 4px;
            background: #e0e0e0;
            margin-right: 2px;
            border-radius: 2px;
            transition: var(--transition);
        }

        .flash-message {
            padding: 1rem;
            border-radius: 10px;
            margin-bottom: 1.5rem;
            text-align: center;
            animation: shake 0.5s ease;
        }

        .flash-message.error {
            background: rgba(231, 76, 60, 0.1);
            color: var(--error-color);
        }

        .flash-message.success {
            background: rgba(46, 204, 113, 0.1);
            color: var(--success-color);
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

        .login-link {
            text-align: center;
            color: #666;
        }

        .login-link a {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 500;
            transition: var(--transition);
        }

        .login-link a:hover {
            color: var(--secondary-color);
            text-decoration: underline;
        }

        /* Terms and Privacy */
        .terms {
            text-align: center;
            font-size: 0.85rem;
            color: #666;
            margin-top: 1rem;
        }

        .terms a {
            color: var(--primary-color);
            text-decoration: none;
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

            .register-card {
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
    <h1>Create Account</h1>
    <p>Join GreenScape and transform your outdoor space</p>
</header>

<main class="container">
    <div class="register-card">
        <div class="form-header">
            <i class="fas fa-user-plus"></i>
            <h2>Register Your Account</h2>
        </div>

        <?php if ($flash = getFlash()): ?>
            <div class="flash-message <?= strpos(strtolower($flash), 'error') !== false ? 'error' : 'success' ?>">
                <i class="fas <?= strpos(strtolower($flash), 'error') !== false ? 'fa-exclamation-circle' : 'fa-check-circle' ?>"></i>
                <?= $flash ?>
            </div>
        <?php endif; ?>

        <form method="POST" id="registerForm">
            <div class="form-group">
                <input type="text" 
                       name="username" 
                       id="username" 
                       required 
                       placeholder="Choose a username"
                       pattern="[A-Za-z0-9_]{3,}"
                       title="Username must be at least 3 characters long and can only contain letters, numbers, and underscores">
                <i class="fas fa-user"></i>
            </div>

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
                       placeholder="Create a password"
                       minlength="8">
                <i class="fas fa-lock"></i>
                <div class="password-strength">
                    <span></span>
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </div>

            <button type="submit" class="submit-button">
                <i class="fas fa-user-plus"></i> Create Account
            </button>

            <div class="login-link">
                <p>Already have an account? <a href="login.php">Login here</a></p>
            </div>

            <div class="terms">
                By registering, you agree to our 
                <a href="#">Terms of Service</a> and 
                <a href="#">Privacy Policy</a>
            </div>
        </form>
    </div>
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('registerForm');
    const inputs = form.querySelectorAll('input');
    const passwordInput = document.getElementById('password');
    const strengthBars = document.querySelectorAll('.password-strength span');

    // Add form submission animation
    form.addEventListener('submit', function(e) {
        const button = form.querySelector('.submit-button');
        button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Creating Account...';
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

    // Password strength indicator
    function checkPasswordStrength(password) {
        let strength = 0;
        if (password.length >= 8) strength++;
        if (password.match(/[A-Z]/)) strength++;
        if (password.match(/[0-9]/)) strength++;
        if (password.match(/[^A-Za-z0-9]/)) strength++;

        strengthBars.forEach((bar, index) => {
            if (index < strength) {
                bar.style.background = [
                    '#e74c3c',
                    '#f39c12',
                    '#f1c40f',
                    '#2ecc71'
                ][strength - 1];
            } else {
                bar.style.background = '#e0e0e0';
            }
        });
    }

    passwordInput.addEventListener('input', function() {
        checkPasswordStrength(this.value);
    });
});
</script>

</body>
</html>