<?php
require_once '../includes/db.php';
require_once '../includes/functions.php';
require_once '../admin/includes/auth.php';
requireUser();

if (!isLoggedIn()) {
    setFlash("You must be logged in to view your profile.");
    redirect('login.php');
}

$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile | GreenScape</title>
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
            background: linear-gradient(135deg, #27ae60 0%, #2ecc71 100%);
            min-height: 100vh;
        }

        .container {
            width: 90%;
            max-width: 1000px;
            margin: 0 auto;
            padding: 2rem 20px;
        }

        /* Header Styles */
        header {
            text-align: center;
            padding: 3rem 0;
            color: white;
            position: relative;
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

        /* Profile Section */
        .profile-container {
            display: grid;
            grid-template-columns: 300px 1fr;
            gap: 2rem;
            margin-top: -2rem;
            animation: fadeInUp 1s ease;
        }

        /* Profile Sidebar */
        .profile-sidebar {
            background: white;
            border-radius: 15px;
            padding: 2rem;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            text-align: center;
        }

        .profile-avatar {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            background: var(--light-color);
            margin: 0 auto 1.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 4rem;
            color: var(--primary-color);
            position: relative;
        }

        .edit-avatar {
            position: absolute;
            bottom: 0;
            right: 0;
            background: var(--primary-color);
            color: white;
            width: 35px;
            height: 35px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: var(--transition);
        }

        .edit-avatar:hover {
            background: var(--secondary-color);
            transform: scale(1.1);
        }

        .profile-name {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .profile-role {
            color: var(--primary-color);
            font-weight: 500;
            margin-bottom: 1.5rem;
        }

        .profile-stats {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
            margin: 1.5rem 0;
        }

        .stat-item {
            background: var(--light-color);
            padding: 1rem;
            border-radius: 10px;
            transition: var(--transition);
        }

        .stat-item:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .stat-number {
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--primary-color);
        }

        .stat-label {
            font-size: 0.9rem;
            color: #666;
        }

        /* Profile Content */
        .profile-content {
            background: white;
            border-radius: 15px;
            padding: 2rem;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }

        .content-section {
            margin-bottom: 2rem;
        }

        .section-title {
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .info-item {
            display: flex;
            align-items: center;
            margin-bottom: 1rem;
            padding: 1rem;
            background: var(--light-color);
            border-radius: 10px;
            transition: var(--transition);
        }

        .info-item:hover {
            transform: translateX(5px);
        }

        .info-item i {
            font-size: 1.2rem;
            color: var(--primary-color);
            margin-right: 1rem;
        }

        .info-label {
            font-weight: 500;
            margin-right: 0.5rem;
        }

        .info-value {
            color: #666;
        }

        .action-buttons {
            display: flex;
            gap: 1rem;
            margin-top: 2rem;
        }

        .action-button {
            flex: 1;
            padding: 1rem;
            border: none;
            border-radius: 10px;
            font-size: 1rem;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            transition: var(--transition);
            text-decoration: none;
        }

        .primary-button {
            background: var(--primary-color);
            color: white;
        }

        .danger-button {
            background: #e74c3c;
            color: white;
        }

        .action-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
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
            .profile-container {
                grid-template-columns: 1fr;
            }

            .back-button {
                top: 1rem;
                left: 1rem;
            }

            header h1 {
                font-size: 2rem;
                margin-top: 2rem;
            }
        }
    </style>
</head>
<body>

<header>
    <a href="../index.php" class="back-button">
        <i class="fas fa-arrow-left"></i> Back to Home
    </a>
    <h1>My Profile</h1>
</header>

<main class="container">
    <div class="profile-container">
        <!-- Profile Sidebar -->
        <div class="profile-sidebar">
            <div class="profile-avatar">
                <i class="fas fa-user"></i>
                <div class="edit-avatar">
                    <i class="fas fa-camera"></i>
                </div>
            </div>
            <div class="profile-name"><?= e($user['username']); ?></div>
            <div class="profile-role"><?= e($user['role']); ?></div>
            
            <div class="profile-stats">
                <div class="stat-item">
                    <div class="stat-number">12</div>
                    <div class="stat-label">Projects</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">4</div>
                    <div class="stat-label">Reviews</div>
                </div>
            </div>

            <div class="action-buttons">
                <!-- <a href="edit-profile.php" class="action-button primary-button">
                    <i class="fas fa-edit"></i> Edit Profile
                </a> -->
            </div>
        </div>

        <!-- Profile Content -->
        <div class="profile-content">
            <div class="content-section">
                <h2 class="section-title">
                    <i class="fas fa-user-circle"></i> Account Information
                </h2>
                <div class="info-item">
                    <i class="fas fa-user"></i>
                    <span class="info-label">Username:</span>
                    <span class="info-value"><?= e($user['username']); ?></span>
                </div>
                <div class="info-item">
                    <i class="fas fa-envelope"></i>
                    <span class="info-label">Email:</span>
                    <span class="info-value"><?= e($user['email']); ?></span>
                </div>
                <div class="info-item">
                    <i class="fas fa-shield-alt"></i>
                    <span class="info-label">Role:</span>
                    <span class="info-value"><?= e($user['role']); ?></span>
                </div>
                <div class="info-item">
                    <i class="fas fa-clock"></i>
                    <span class="info-label">Current Time (UTC):</span>
                    <span class="info-value">2025-05-29 05:52:22</span>
                </div>
            </div>

            <div class="content-section">
                <h2 class="section-title">
                    <i class="fas fa-cog"></i> Account Settings
                </h2>
                <div class="action-buttons">
                    <!-- <a href="change-password.php" class="action-button primary-button">
                        <i class="fas fa-key"></i> Change Password
                    </a> -->
                    <a href="logout.php" class="action-button danger-button">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add hover effects for interactive elements
    const infoItems = document.querySelectorAll('.info-item');
    infoItems.forEach(item => {
        item.addEventListener('mouseenter', () => {
            item.style.transform = 'translateX(10px)';
        });
        item.addEventListener('mouseleave', () => {
            item.style.transform = 'translateX(0)';
        });
    });

    // Add animation for stat items
    const statItems = document.querySelectorAll('.stat-item');
    statItems.forEach(item => {
        item.addEventListener('mouseenter', () => {
            item.style.transform = 'translateY(-5px)';
        });
        item.addEventListener('mouseleave', () => {
            item.style.transform = 'translateY(0)';
        });
    });
});
</script>

</body>
</html>