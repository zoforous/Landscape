<?php
require_once '../includes/functions.php';

// Get the message from URL parameter or set default
$message = $_GET['message'] ?? 'Thank you for your submission!';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank You | GreenScape</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #2ecc71;
            --secondary-color: #27ae60;
            --dark-color: #2c3e50;
            --light-color: #ecf0f1;
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
            background: #f8f9fa;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }

        .time-display {
            position: fixed;
            top: 1rem;
            right: 1rem;
            background: white;
            padding: 0.75rem 1rem;
            border-radius: 50px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            display: flex;
            align-items: center;
            gap: 0.5rem;
            z-index: 1000;
            font-size: 0.9rem;
        }

        .time-display i {
            color: var(--primary-color);
        }

        .thank-you-container {
            background: white;
            padding: 3rem;
            border-radius: 20px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            text-align: center;
            max-width: 600px;
            width: 100%;
            animation: slideIn 0.5s ease;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .success-icon {
            width: 100px;
            height: 100px;
            background: var(--success-color);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 2rem;
            color: white;
            font-size: 3rem;
            animation: scaleIn 0.5s ease 0.3s both;
        }

        @keyframes scaleIn {
            from {
                transform: scale(0);
            }
            to {
                transform: scale(1);
            }
        }

        .thank-you-title {
            font-size: 2rem;
            color: var(--dark-color);
            margin-bottom: 1rem;
            font-weight: 600;
        }

        .thank-you-message {
            color: #666;
            margin-bottom: 2rem;
            font-size: 1.1rem;
        }

        .back-home {
            display: inline-block;
            padding: 1rem 2rem;
            background: var(--primary-color);
            color: white;
            text-decoration: none;
            border-radius: 50px;
            font-weight: 500;
            transition: var(--transition);
        }

        .back-home:hover {
            background: var(--secondary-color);
            transform: translateY(-2px);
        }

        @media (max-width: 768px) {
            .time-display {
                position: relative;
                top: auto;
                right: auto;
                margin-bottom: 2rem;
            }

            .thank-you-container {
                padding: 2rem;
                margin: 1rem;
            }

            .thank-you-title {
                font-size: 1.5rem;
            }

            .thank-you-message {
                font-size: 1rem;
            }
        }
    </style>
</head>
<body>
    <div class="time-display">
        <i class="fas fa-clock"></i>
        <span id="current-time">Current Date and Time (UTC - YYYY-MM-DD HH:MM:SS formatted): 2025-05-29 06:57:52</span>
    </div>

    <div class="thank-you-container">
        <div class="success-icon">
            <i class="fas fa-check"></i>
        </div>
        <h1 class="thank-you-title">Thank You!</h1>
        <p class="thank-you-message"><?= e($message) ?></p>
        <a href="../index.php" class="back-home">
            <i class="fas fa-home"></i> Back to Home
        </a>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        function formatUTCTime() {
            const now = new Date();
            const year = now.getUTCFullYear();
            const month = String(now.getUTCMonth() + 1).padStart(2, '0');
            const day = String(now.getUTCDate()).padStart(2, '0');
            const hours = String(now.getUTCHours()).padStart(2, '0');
            const minutes = String(now.getUTCMinutes()).padStart(2, '0');
            const seconds = String(now.getUTCSeconds()).padStart(2, '0');
            
            return `Current Date and Time (UTC - YYYY-MM-DD HH:MM:SS formatted): ${year}-${month}-${day} ${hours}:${minutes}:${seconds}`;
        }

        function updateTime() {
            const timeElement = document.getElementById('current-time');
            timeElement.textContent = formatUTCTime();
        }

        // Initialize time and update every second
        updateTime();
        setInterval(updateTime, 1000);
    });
    </script>
</body>
</html>