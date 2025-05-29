<?php include '../includes/functions.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our Services | GreenScape</title>
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
            margin-bottom: 2rem;
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

        /* Services Grid */
        .services-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            padding: 4rem 0;
        }

        .service-card {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            transition: var(--transition);
            position: relative;
            top: 0;
        }

        .service-card:hover {
            top: -10px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        }

        .service-image {
            height: 200px;
            background-size: cover;
            background-position: center;
        }

        .service-content {
            padding: 2rem;
        }

        .service-card h2 {
            color: var(--dark-color);
            margin-bottom: 1rem;
            font-size: 1.5rem;
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .service-card i {
            color: var(--primary-color);
            font-size: 1.8rem;
        }

        .service-card p {
            color: #666;
            margin-bottom: 1.5rem;
        }

        .service-card .price-range {
            color: var(--primary-color);
            font-weight: 500;
            margin-bottom: 1rem;
        }

        .service-card .cta-button {
            display: inline-block;
            padding: 0.75rem 1.5rem;
            background: var(--primary-color);
            color: white;
            text-decoration: none;
            border-radius: 50px;
            transition: var(--transition);
            text-align: center;
            width: 100%;
        }

        .service-card .cta-button:hover {
            background: var(--secondary-color);
        }

        /* Footer */
        footer {
            background: var(--dark-color);
            color: white;
            text-align: center;
            padding: 2rem 0;
            margin-top: 4rem;
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

            .services-grid {
                grid-template-columns: 1fr;
                padding: 2rem 0;
            }
        }
    </style>
</head>
<body>

<header>
    <a href="../index.php" class="back-button">
        <i class="fas fa-arrow-left"></i> Back to Home
    </a>
    <h1>Our Landscaping Services</h1>
</header>

<main class="container">
    <div class="services-grid">
        <div class="service-card">
            <div class="service-image" style="background-image: url('https://images.unsplash.com/photo-1558904541-efa843a96f01?auto=format&fit=crop&w=800&q=80')"></div>
            <div class="service-content">
                <h2><i class="fas fa-cut"></i> Lawn Care</h2>
                <p>Regular mowing, fertilising, and weed control for lush green lawns. Our expert team ensures your lawn stays healthy and beautiful all year round.</p>
                <div class="price-range">
                    <i class="fas fa-tag"></i> Starting from $50/visit
                </div>
                <a href="../pages/estimate.php?service=lawn" class="cta-button">Get Quote</a>
            </div>
        </div>

        <div class="service-card">
            <div class="service-image" style="background-image: url('https://images.unsplash.com/photo-1558904541-efa843a96f01?auto=format&fit=crop&w=800&q=80')"></div>
            <div class="service-content">
                <h2><i class="fas fa-seedling"></i> Garden Design</h2>
                <p>Customised planting, layout, and visual themes tailored to your space. Transform your outdoor area into a stunning landscape that reflects your style.</p>
                <div class="price-range">
                    <i class="fas fa-tag"></i> Starting from $300/project
                </div>
                <a href="../pages/estimate.php?service=garden" class="cta-button">Get Quote</a>
            </div>
        </div>

        <div class="service-card">
            <div class="service-image" style="background-image: url('https://images.unsplash.com/photo-1558904541-efa843a96f01?auto=format&fit=crop&w=800&q=80')"></div>
            <div class="service-content">
                <h2><i class="fas fa-layer-group"></i> Hardscaping</h2>
                <p>Patios, paths, retaining walls, and decorative stone features. Add structure and functionality to your outdoor space with our expert hardscaping services.</p>
                <div class="price-range">
                    <i class="fas fa-tag"></i> Starting from $1000/project
                </div>
                <a href="../pages/estimate.php?service=hardscape" class="cta-button">Get Quote</a>
            </div>
        </div>
    </div>
</main>

<footer>
    <p>&copy; <?= date('Y') ?> GreenScape Landscaping</p>
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

    // Animate services cards on scroll
    const observerOptions = {
        threshold: 0.1
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, observerOptions);

    document.querySelectorAll('.service-card').forEach(card => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        card.style.transition = 'all 0.6s ease';
        observer.observe(card);
    });
</script>

</body>
</html>