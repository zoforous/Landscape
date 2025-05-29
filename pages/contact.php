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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us | GreenScape</title>
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
            background-color: var(--light-color);
        }

        .container {
            width: 90%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem 20px;
        }

        /* Header Styles */
        header {
            background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.7)), 
                        url('https://images.unsplash.com/photo-1558904541-efa843a96f01?auto=format&fit=crop&w=1600&q=80');
            background-size: cover;
            background-position: center;
            color: white;
            text-align: center;
            padding: 8rem 0 6rem;
            position: relative;
        }

        header h1 {
            font-size: 3rem;
            margin-bottom: 1rem;
            animation: fadeInDown 1s ease;
        }

        header p {
            font-size: 1.2rem;
            max-width: 600px;
            margin: 0 auto;
            animation: fadeInUp 1s ease;
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

        /* Contact Section */
        .contact-container {
            display: grid;
            grid-template-columns: 1fr 1.5fr;
            gap: 2rem;
            margin-top: -4rem;
            position: relative;
            z-index: 1;
            animation: fadeInUp 1s ease;
        }

        /* Contact Info */
        .contact-info {
            background: white;
            padding: 2rem;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .contact-info h2 {
            color: var(--dark-color);
            margin-bottom: 1.5rem;
            font-size: 1.5rem;
        }

        .info-item {
            display: flex;
            align-items: center;
            margin-bottom: 1.5rem;
            padding: 1rem;
            background: var(--light-color);
            border-radius: 10px;
            transition: var(--transition);
        }

        .info-item:hover {
            transform: translateX(5px);
            background: rgba(46, 204, 113, 0.1);
        }

        .info-item i {
            font-size: 1.5rem;
            color: var(--primary-color);
            margin-right: 1rem;
        }

        .info-details h3 {
            font-size: 1rem;
            margin-bottom: 0.25rem;
        }

        .info-details p {
            color: #666;
            font-size: 0.9rem;
        }

        /* Contact Form */
        .contact-form {
            background: white;
            padding: 2rem;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: var(--dark-color);
        }

        input[type="text"],
        input[type="email"],
        input[type="tel"],
        textarea {
            width: 100%;
            padding: 1rem;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            font-size: 1rem;
            transition: var(--transition);
            outline: none;
        }

        input:focus,
        textarea:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(46, 204, 113, 0.1);
        }

        textarea {
            height: 150px;
            resize: vertical;
        }

        .submit-button {
            background: var(--primary-color);
            color: white;
            border: none;
            padding: 1rem 2rem;
            font-size: 1.1rem;
            border-radius: 50px;
            cursor: pointer;
            width: 100%;
            transition: var(--transition);
            font-weight: 500;
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

        /* Social Media Links */
        .social-links {
            display: flex;
            gap: 1rem;
            margin-top: 2rem;
        }

        .social-link {
            width: 40px;
            height: 40px;
            background: var(--light-color);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--dark-color);
            text-decoration: none;
            transition: var(--transition);
        }

        .social-link:hover {
            background: var(--primary-color);
            color: white;
            transform: translateY(-3px);
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

        /* Responsive Design */
        @media (max-width: 968px) {
            .contact-container {
                grid-template-columns: 1fr;
            }

            header h1 {
                font-size: 2rem;
            }

            .back-button {
                top: 1rem;
                left: 1rem;
            }
        }

        @media (max-width: 480px) {
            .contact-container {
                margin-top: -2rem;
            }

            .contact-form,
            .contact-info {
                padding: 1.5rem;
            }
        }
    </style>
</head>
<body>

<header>
    <a href="../index.php" class="back-button">
        <i class="fas fa-arrow-left"></i> Back to Home
    </a>
    <h1>Contact Us</h1>
    <p>Get in touch with our team and let us help bring your vision to life</p>
</header>

<main class="container">
    <div class="contact-container">
        <div class="contact-info">
            <h2>Get In Touch</h2>
            <div class="info-item">
                <i class="fas fa-map-marker-alt"></i>
                <div class="info-details">
                    <h3>Our Location</h3>
                    <p>123 Landscape Drive, Garden City, GC 12345</p>
                </div>
            </div>
            <div class="info-item">
                <i class="fas fa-phone"></i>
                <div class="info-details">
                    <h3>Phone Number</h3>
                    <p>+1 (555) 123-4567</p>
                </div>
            </div>
            <div class="info-item">
                <i class="fas fa-envelope"></i>
                <div class="info-details">
                    <h3>Email Address</h3>
                    <p>info@greenscape.com</p>
                </div>
            </div>
            <div class="info-item">
                <i class="fas fa-clock"></i>
                <div class="info-details">
                    <h3>Working Hours</h3>
                    <p>Mon - Fri: 8:00 AM - 6:00 PM</p>
                </div>
            </div>
            
            <div class="social-links">
                <a href="#" class="social-link"><i class="fab fa-facebook-f"></i></a>
                <a href="#" class="social-link"><i class="fab fa-twitter"></i></a>
                <a href="#" class="social-link"><i class="fab fa-instagram"></i></a>
                <a href="#" class="social-link"><i class="fab fa-linkedin-in"></i></a>
            </div>
        </div>

        <div class="contact-form">
            <form method="POST" id="contactForm">
                <div class="form-group">
                    <label for="name"><i class="fas fa-user"></i> Name</label>
                    <input type="text" 
                           id="name" 
                           name="name" 
                           required 
                           placeholder="Enter your name">
                </div>

                <div class="form-group">
                    <label for="email"><i class="fas fa-envelope"></i> Email</label>
                    <input type="email" 
                           id="email" 
                           name="email" 
                           required 
                           placeholder="Enter your email">
                </div>

                <div class="form-group">
                    <label for="phone"><i class="fas fa-phone"></i> Phone (Optional)</label>
                    <input type="tel" 
                           id="phone" 
                           name="phone" 
                           placeholder="Enter your phone number">
                </div>

                <div class="form-group">
                    <label for="message"><i class="fas fa-comment"></i> Message</label>
                    <textarea id="message" 
                              name="message" 
                              required 
                              placeholder="How can we help you?"></textarea>
                </div>

                <button type="submit" class="submit-button">
                    <i class="fas fa-paper-plane"></i>
                    Send Message
                </button>
            </form>
        </div>
    </div>
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('contactForm');
    
    // Add form submission animation
    form.addEventListener('submit', function(e) {
        const button = form.querySelector('.submit-button');
        button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Sending...';
    });

    // Add input focus effects
    const inputs = form.querySelectorAll('input, textarea');
    inputs.forEach(input => {
        input.addEventListener('focus', function() {
            this.parentElement.style.transform = 'translateX(5px)';
        });

        input.addEventListener('blur', function() {
            this.parentElement.style.transform = 'translateX(0)';
        });
    });

    // Add smooth scrolling
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            document.querySelector(this.getAttribute('href')).scrollIntoView({
                behavior: 'smooth'
            });
        });
    });
});
</script>

</body>
</html>