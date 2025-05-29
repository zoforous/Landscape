<?php
require_once '../includes/functions.php';
require_once 'includes/auth.php';

requireAdmin();

if (!isset($_SESSION['admin_id'])) {
    setFlash("Admin access required.");
    redirect('login.php');
}
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
            background: #f8f9fa;
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
            z-index: 1000;
            background: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            color: var(--dark-color);
        }

        .time-display i {
            color: var(--primary-color);
        }

        .dashboard {
            display: grid;
            grid-template-columns: 250px 1fr;
            min-height: 100vh;
        }

        /* Sidebar Styles */
        .sidebar {
            background: white;
            padding: 2rem;
            border-right: 1px solid rgba(0,0,0,0.1);
            position: fixed;
            width: 250px;
            height: 100vh;
            overflow-y: auto;
        }

        .sidebar-header {
            text-align: center;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid rgba(0,0,0,0.1);
        }

        .sidebar-logo {
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--dark-color);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            margin-bottom: 1rem;
        }

        .sidebar-logo i {
            color: var(--primary-color);
        }

        .admin-info {
            text-align: center;
            padding: 1.5rem;
            background: var(--light-color);
            border-radius: 15px;
            margin-bottom: 2rem;
        }

        .admin-avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            font-size: 2rem;
            color: var(--primary-color);
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }

        .admin-name {
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: var(--dark-color);
        }

        .admin-role {
            font-size: 0.9rem;
            color: var(--primary-color);
            font-weight: 500;
        }

        .nav-menu {
            list-style: none;
        }

        .nav-item {
            margin-bottom: 0.5rem;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 1rem;
            color: var(--dark-color);
            text-decoration: none;
            border-radius: 10px;
            transition: var(--transition);
        }

        .nav-link:hover {
            background: var(--light-color);
            transform: translateX(5px);
        }

        .nav-link.active {
            background: var(--primary-color);
            color: white;
        }

        /* Main Content Styles */
        .main-content {
            margin-left: 250px;
            padding: 2rem;
        }

        .page-header {
            background: white;
            padding: 2rem;
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 2rem;
        }

        .header-title {
            font-size: 1.75rem;
            font-weight: 600;
            color: var(--dark-color);
            margin: 0;
            line-height: 1.2;
        }

        .header-subtitle {
            color: #666;
            margin: 0.5rem 0 0 0;
            font-size: 1rem;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: white;
            padding: 2rem;
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            transition: var(--transition);
            display: flex;
            align-items: flex-start;
            gap: 1.5rem;
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            flex-shrink: 0;
        }

        .stat-icon.contacts {
            background: rgba(52, 152, 219, 0.1);
            color: var(--info-color);
        }

        .stat-icon.estimates {
            background: rgba(46, 204, 113, 0.1);
            color: var(--success-color);
        }

        .stat-content {
            flex: 1;
        }

        .stat-number {
            font-size: 2rem;
            font-weight: 600;
            color: var(--dark-color);
            margin-bottom: 0.5rem;
            line-height: 1;
        }

        .stat-label {
            color: #666;
            font-size: 0.9rem;
            margin: 0;
        }

        .quick-actions {
            background: white;
            padding: 2rem;
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .section-title {
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
            color: var(--dark-color);
        }

        .actions-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
        }

        .action-card {
            padding: 1.5rem;
            border-radius: 15px;
            text-decoration: none;
            color: var(--dark-color);
            transition: var(--transition);
            background: var(--light-color);
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .action-card:hover {
            transform: translateY(-3px);
            background: var(--primary-color);
            color: white;
        }

        /* Responsive Design */
        @media (max-width: 1024px) {
            .dashboard {
                grid-template-columns: 1fr;
            }

            .sidebar {
                display: none;
            }

            .main-content {
                margin-left: 0;
            }
        }

        @media (max-width: 768px) {
            .time-display {
                position: relative;
                top: auto;
                right: auto;
                margin-bottom: 1rem;
                justify-content: center;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }

            .actions-grid {
                grid-template-columns: 1fr;
            }

            .stat-card {
                padding: 1.5rem;
            }
        }
    </style>
</head>
<body>

<div class="time-display">
    <i class="fas fa-clock"></i>
    <span id="current-time">2025-05-29 06:34:39</span>
</div>

<div class="dashboard">
    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="sidebar-header">
            <div class="sidebar-logo">
                <i class="fas fa-leaf"></i>
                <span>GreenScape</span>
            </div>
            <div class="admin-info">
                <div class="admin-avatar">
                    <i class="fas fa-user"></i>
                </div>
                <div class="admin-name"><?= e($_SESSION['admin_username'] ?? 'zoforous'); ?></div>
                <div class="admin-role">Administrator</div>
            </div>
        </div>

        <ul class="nav-menu">
            <li class="nav-item">
                <a href="dashboard.php" class="nav-link active">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="manage-contacts.php" class="nav-link">
                    <i class="fas fa-envelope"></i>
                    <span>Contact Submissions</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="manage-estimates.php" class="nav-link">
                    <i class="fas fa-calculator"></i>
                    <span>Cost Estimates</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="logout.php" class="nav-link" style="color: var(--danger-color);">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Logout</span>
                </a>
            </li>
        </ul>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
        <div class="page-header">
            <h1 class="header-title">Cost Estimates Overview</h1>
            <!-- <p class="header-subtitle">Track and manage your landscape estimates</p> -->
        </div>

        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon estimates">
                    <i class="fas fa-file-invoice-dollar"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-number">28</div>
                    <div class="stat-label">Total Estimates</div>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon contacts">
                    <i class="fas fa-dollar-sign"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-number">$15,750</div>
                    <div class="stat-label">Total Value</div>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon estimates">
                    <i class="fas fa-chart-line"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-number">$562</div>
                    <div class="stat-label">Average Value</div>
                </div>
            </div>
        </div>

        <div class="quick-actions">
            <h2 class="section-title">Quick Actions</h2>
            <div class="actions-grid">
                <a href="manage-contacts.php" class="action-card">
                    <i class="fas fa-envelope"></i>
                    <span>Manage Contacts</span>
                </a>
                <a href="manage-estimates.php" class="action-card">
                    <i class="fas fa-calculator"></i>
                    <span>Manage Estimates</span>
                </a>
            </div>
        </div>
    </main>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Update time every second
    function updateTime() {
        const timeElement = document.getElementById('current-time');
        const now = new Date();
        const utcString = now.toISOString().slice(0, 19).replace('T', ' ');
        timeElement.textContent = utcString;
    }

    // Update immediately and then every second
    updateTime();
    setInterval(updateTime, 1000);

    // Add hover animations for navigation items
    const navLinks = document.querySelectorAll('.nav-link');
    navLinks.forEach(link => {
        if (!link.classList.contains('active')) {
            link.addEventListener('mouseenter', () => {
                link.style.transform = 'translateX(10px)';
            });
            link.addEventListener('mouseleave', () => {
                link.style.transform = 'translateX(0)';
            });
        }
    });

    // Add hover animations for stat cards
    const statCards = document.querySelectorAll('.stat-card');
    statCards.forEach(card => {
        card.addEventListener('mouseenter', () => {
            card.style.transform = 'translateY(-10px)';
            card.style.boxShadow = '0 5px 15px rgba(46, 204, 113, 0.2)';
        });
        card.addEventListener('mouseleave', () => {
            card.style.transform = 'translateY(0)';
            card.style.boxShadow = '0 2px 10px rgba(0,0,0,0.1)';
        });
    });

        // Add hover animations for action cards
    const actionCards = document.querySelectorAll('.action-card');
    actionCards.forEach(card => {
        card.addEventListener('mouseenter', () => {
            card.style.transform = 'translateY(-5px)';
            card.style.boxShadow = '0 5px 15px rgba(46, 204, 113, 0.2)';
        });
        card.addEventListener('mouseleave', () => {
            card.style.transform = 'translateY(0)';
            card.style.boxShadow = 'none';
        });
    });

    // Format UTC time function
    function formatUTCTime() {
        const now = new Date();
        const year = now.getUTCFullYear();
        const month = String(now.getUTCMonth() + 1).padStart(2, '0');
        const day = String(now.getUTCDate()).padStart(2, '0');
        const hours = String(now.getUTCHours()).padStart(2, '0');
        const minutes = String(now.getUTCMinutes()).padStart(2, '0');
        const seconds = String(now.getUTCSeconds()).padStart(2, '0');
        
        return `${year}-${month}-${day} ${hours}:${minutes}:${seconds}`;
    }

    // Update time function with new format
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