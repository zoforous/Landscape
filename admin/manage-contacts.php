<?php
require_once '../includes/db.php';
require_once '../includes/functions.php';

if (!isset($_SESSION['admin_id'])) {
    redirect('login.php');
}

$stmt = $pdo->query("SELECT * FROM contacts ORDER BY submitted_at DESC");
$contacts = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Contacts | GreenScape Admin</title>
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
            position: relative;
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

        .user-info {
            position: fixed;
            top: 4rem;
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

        .user-info i {
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

        .admin-info {
            text-align: center;
            padding: 1rem;
            background: var(--light-color);
            border-radius: 10px;
            margin-bottom: 2rem;
        }

        .admin-avatar {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            font-size: 1.5rem;
            color: var(--primary-color);
        }

        .admin-name {
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .admin-role {
            font-size: 0.9rem;
            color: var(--primary-color);
        }

        /* Main Content Styles */
        .main-content {
            margin-left: 250px;
            padding: 2rem;
            padding-top: 7rem; /* Account for fixed time display */
        }

        .page-header {
            background: white;
            padding: 1.5rem;
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 2rem;
        }

        .header-title {
            font-size: 1.5rem;
            font-weight: 600;
        }

        .contact-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: white;
            padding: 1.5rem;
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .stat-number {
            font-size: 2rem;
            font-weight: 600;
            color: var(--primary-color);
            margin-bottom: 0.5rem;
        }

        .stat-label {
            color: #666;
            font-size: 0.9rem;
        }

        /* Rest of your existing styles... */

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
            .main-content {
                padding-top: 2rem;
            }

            .time-display, .user-info {
                position: relative;
                top: auto;
                right: auto;
                margin-bottom: 1rem;
                justify-content: center;
            }

            .contact-stats {
                grid-template-columns: 1fr;
            }

            .table-responsive {
                overflow-x: auto;
            }

            th, td {
                min-width: 120px;
            }

            .action-cell {
                min-width: 100px;
            }
        }
    </style>
</head>
<body>

<div class="time-display">
    <i class="fas fa-clock"></i>
    <span id="current-time">Current Date and Time (UTC - YYYY-MM-DD HH:MM:SS formatted): 2025-05-29 06:44:01</span>
</div>

<div class="user-info">
    <i class="fas fa-user"></i>
    <span>Current User's Login: <?= e($_SESSION['admin_username'] ?? 'zoforous') ?></span>
</div>

<div class="dashboard">
    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="sidebar-header">
            <div class="admin-info">
                <div class="admin-avatar">
                    <i class="fas fa-user"></i>
                </div>
                <div class="admin-name"><?= e($_SESSION['admin_username'] ?? 'zoforous'); ?></div>
                <div class="admin-role">Administrator</div>
            </div>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
        <div class="page-header">
            <div class="header-title">Contact Submissions</div>
        </div>

        <div class="contact-stats">
            <div class="stat-card">
                <div class="stat-number"><?= count($contacts) ?></div>
                <div class="stat-label">Total Submissions</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">
                    <?php
                    $new_today = 0;
                    foreach ($contacts as $contact) {
                        if (isset($contact['submitted_at']) && strtotime($contact['submitted_at']) > strtotime('-24 hours')) {
                            $new_today++;
                        }
                    }
                    echo $new_today;
                    ?>
                </div>
                <div class="stat-label">New Today</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">
                    <?php
                    $unread = 0;
                    foreach ($contacts as $contact) {
                        if (isset($contact['status']) && $contact['status'] === 'unread') {
                            $unread++;
                        }
                    }
                    echo $unread;
                    ?>
                </div>
                <div class="stat-label">Unread Messages</div>
            </div>
        </div>

        <div class="contacts-table">
            <!-- Rest of your existing table code... -->
        </div>
    </main>
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