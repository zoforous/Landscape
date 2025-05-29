<?php
require_once '../includes/db.php';
require_once '../includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isLoggedIn()) {
    $yard_size = (int) $_POST['yard_size'];
    $design_option = $_POST['design_option'];
    $cost_per_sq = ['basic' => 5, 'premium' => 10, 'luxury' => 15];
    $cost = $yard_size * $cost_per_sq[$design_option];

    $stmt = $pdo->prepare("INSERT INTO estimates (user_id, yard_size, design_option, estimated_cost) VALUES (?, ?, ?, ?)");
    $stmt->execute([$_SESSION['user_id'], $yard_size, $design_option, $cost]);

    redirect('thank-you.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project Cost Estimator | GreenScape</title>
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
            background-color: var(--light-color);
        }

        .container {
            width: 90%;
            max-width: 800px;
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

        /* Form Styles */
        .estimate-form-container {
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            padding: 2rem;
            margin-top: -4rem;
            position: relative;
            z-index: 1;
            animation: fadeInUp 1s ease;
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

        input[type="number"],
        select {
            width: 100%;
            padding: 1rem;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            font-size: 1rem;
            transition: var(--transition);
            outline: none;
        }

        input[type="number"]:focus,
        select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(46, 204, 113, 0.1);
        }

        .design-options {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1rem;
            margin: 1.5rem 0;
        }

        .design-option {
            position: relative;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            padding: 1.5rem;
            cursor: pointer;
            transition: var(--transition);
        }

        .design-option:hover {
            border-color: var(--primary-color);
        }

        .design-option.selected {
            border-color: var(--primary-color);
            background: rgba(46, 204, 113, 0.1);
        }

        .design-option input[type="radio"] {
            position: absolute;
            opacity: 0;
        }

        .design-option-title {
            font-weight: 600;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .design-option-price {
            color: var(--primary-color);
            font-weight: 500;
        }

        .estimate-result {
            background: var(--dark-color);
            color: white;
            padding: 2rem;
            border-radius: 10px;
            margin: 2rem 0;
            text-align: center;
        }

        .estimate-result h3 {
            font-size: 1.2rem;
            margin-bottom: 1rem;
        }

        .estimate-amount {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--primary-color);
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
        }

        .submit-button:hover {
            background: var(--secondary-color);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(46, 204, 113, 0.3);
        }

        /* Login Notice */
        .login-notice {
            text-align: center;
            margin-top: 2rem;
            padding: 1rem;
            background: rgba(231, 76, 60, 0.1);
            border-radius: 10px;
            color: var(--error-color);
        }

        .login-notice a {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 500;
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
        @media (max-width: 768px) {
            header h1 {
                font-size: 2rem;
                padding: 0 1rem;
            }

            .back-button {
                top: 1rem;
                left: 1rem;
            }

            .design-options {
                grid-template-columns: 1fr;
            }

            .estimate-form-container {
                margin-top: -2rem;
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
    <h1>Project Cost Estimator</h1>
    <p>Get an instant estimate for your landscaping project</p>
</header>

<main class="container">
    <div class="estimate-form-container">
        <form method="POST" id="estimateForm">
            <div class="form-group">
                <label for="yard_size">
                    <i class="fas fa-ruler-combined"></i> Yard Size (m²)
                </label>
                <input type="number" 
                       name="yard_size" 
                       id="yard_size" 
                       required 
                       min="1"
                       placeholder="Enter your yard size">
            </div>

            <div class="form-group">
                <label>
                    <i class="fas fa-star"></i> Select Your Design Package
                </label>
                <div class="design-options">
                    <div class="design-option" data-value="basic">
                        <input type="radio" name="design_option" value="basic" required>
                        <div class="design-option-title">
                            <i class="fas fa-leaf"></i> Basic Package
                        </div>
                        <div class="design-option-price">$5/m²</div>
                        <p>Essential landscaping services with quality results</p>
                    </div>

                    <div class="design-option" data-value="premium">
                        <input type="radio" name="design_option" value="premium">
                        <div class="design-option-title">
                            <i class="fas fa-gem"></i> Premium Package
                        </div>
                        <div class="design-option-price">$10/m²</div>
                        <p>Enhanced design with premium materials and features</p>
                    </div>

                    <div class="design-option" data-value="luxury">
                        <input type="radio" name="design_option" value="luxury">
                        <div class="design-option-title">
                            <i class="fas fa-crown"></i> Luxury Package
                        </div>
                        <div class="design-option-price">$15/m²</div>
                        <p>Exclusive designs with high-end materials and features</p>
                    </div>
                </div>
            </div>

            <div class="estimate-result">
                <h3>Estimated Project Cost</h3>
                <div class="estimate-amount" id="result">$0.00</div>
            </div>

            <?php if (!isLoggedIn()): ?>
            <div class="login-notice">
                <i class="fas fa-info-circle"></i>
                Please <a href="../user/login.php">login</a> or <a href="../user/register.php">register</a> to submit your estimate
            </div>
            <?php else: ?>
            <button type="submit" class="submit-button">
                <i class="fas fa-paper-plane"></i> Submit Estimate
            </button>
            <?php endif; ?>
        </form>
    </div>
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('estimateForm');
    const yardSizeInput = document.getElementById('yard_size');
    const resultDisplay = document.getElementById('result');
    const designOptions = document.querySelectorAll('.design-option');

    // Handle design option selection
    designOptions.forEach(option => {
        option.addEventListener('click', () => {
            // Remove selected class from all options
            designOptions.forEach(opt => opt.classList.remove('selected'));
            // Add selected class to clicked option
            option.classList.add('selected');
            // Check the radio input
            option.querySelector('input[type="radio"]').checked = true;
            // Update the estimate
            calculateEstimate();
        });
    });

    // Calculate estimate on input change
    form.addEventListener('input', calculateEstimate);

    function calculateEstimate() {
        const size = parseFloat(yardSizeInput.value) || 0;
        const selectedOption = document.querySelector('input[name="design_option"]:checked');
        
        if (selectedOption) {
            const type = selectedOption.value;
            const rate = { basic: 5, premium: 10, luxury: 15 }[type];
            const total = size * rate;
            
            // Animate the number change
            animateNumber(total);
        }
    }

    function animateNumber(target) {
        const current = parseFloat(resultDisplay.textContent.replace('$', '')) || 0;
        const increment = (target - current) / 20;
        let value = current;

        function updateNumber() {
            if ((increment > 0 && value < target) || (increment < 0 && value > target)) {
                value += increment;
                resultDisplay.textContent = '$' + value.toFixed(2);
                requestAnimationFrame(updateNumber);
            } else {
                resultDisplay.textContent = '$' + target.toFixed(2);
            }
        }

        updateNumber();
    }

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