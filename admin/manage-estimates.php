<?php
require_once '../includes/db.php';
require_once '../includes/functions.php';

if (!isset($_SESSION['admin_id'])) {
    redirect('login.php');
}

$stmt = $pdo->query("
    SELECT e.*, u.username 
    FROM estimates e 
    JOIN users u ON e.user_id = u.id 
    ORDER BY e.created_at DESC");
$estimates = $stmt->fetchAll();

// Calculate statistics
$totalEstimates = count($estimates);
$totalValue = array_sum(array_column($estimates, 'estimated_cost'));
$averageCost = $totalEstimates > 0 ? $totalValue / $totalEstimates : 0;
$recentEstimates = array_filter($estimates, function($e) {
    return strtotime($e['created_at']) > strtotime('-24 hours');
});
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Estimates | GreenScape Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/chart.js" rel="stylesheet">
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

        /* Main Content Styles */
        .main-content {
            margin-left: 250px;
            padding: 2rem;
            padding-top: 7rem;
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

        /* Statistics Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: white;
            padding: 1.5rem;
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            transition: var(--transition);
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .stat-icon {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1rem;
            font-size: 1.5rem;
        }

        .stat-icon.total {
            background: rgba(52, 152, 219, 0.1);
            color: var(--info-color);
        }

        .stat-icon.value {
            background: rgba(46, 204, 113, 0.1);
            color: var(--success-color);
        }

        .stat-icon.average {
            background: rgba(241, 196, 15, 0.1);
            color: var(--warning-color);
        }

        .stat-number {
            font-size: 1.8rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .stat-label {
            color: #666;
            font-size: 0.9rem;
        }

        /* Charts Container */
        .charts-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .chart-card {
            background: white;
            padding: 1.5rem;
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        /* Estimates Table */
        .estimates-table {
            background: white;
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            overflow: hidden;
        }

        .table-header {
            padding: 1.5rem;
            border-bottom: 1px solid rgba(0,0,0,0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .search-box {
            position: relative;
        }

        .search-input {
            padding: 0.5rem 1rem 0.5rem 2.5rem;
            border: 1px solid #e0e0e0;
            border-radius: 50px;
            outline: none;
            transition: var(--transition);
        }

        .search-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #999;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 1rem;
            text-align: left;
            border-bottom: 1px solid #e0e0e0;
        }

        th {
            background: #f8f9fa;
            font-weight: 600;
        }

        tbody tr {
            transition: var(--transition);
        }

        tbody tr:hover {
            background: #f8f9fa;
        }

        .design-badge {
            padding: 0.25rem 0.75rem;
            border-radius: 50px;
            font-size: 0.85rem;
            font-weight: 500;
        }

        .design-minimal {
            background: rgba(52, 152, 219, 0.1);
            color: var(--info-color);
        }

        .design-moderate {
            background: rgba(241, 196, 15, 0.1);
            color: var(--warning-color);
        }

        .design-luxury {
            background: rgba(46, 204, 113, 0.1);
            color: var(--success-color);
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

            .charts-container {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 768px) {
            .time-display, .user-info {
                position: relative;
                top: auto;
                right: auto;
                margin-bottom: 1rem;
                justify-content: center;
            }

            .main-content {
                padding-top: 2rem;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }

            .table-responsive {
                overflow-x: auto;
            }

            th, td {
                min-width: 120px;
            }
        }
    </style>
</head>
<body>

<div class="time-display">
    <i class="fas fa-clock"></i>
    <span id="current-time">Current Date and Time (UTC - YYYY-MM-DD HH:MM:SS formatted): 2025-05-29 06:53:57</span>
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
            <div class="header-title">Cost Estimates Overview</div>
        </div>

        <!-- Statistics -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon total">
                    <i class="fas fa-file-invoice-dollar"></i>
                </div>
                <div class="stat-number"><?= $totalEstimates ?></div>
                <div class="stat-label">Total Estimates</div>
            </div>

            <div class="stat-card">
                <div class="stat-icon value">
                    <i class="fas fa-dollar-sign"></i>
                </div>
                <div class="stat-number">$<?= number_format($totalValue) ?></div>
                <div class="stat-label">Total Value</div>
            </div>

            <div class="stat-card">
                <div class="stat-icon average">
                    <i class="fas fa-chart-line"></i>
                </div>
                <div class="stat-number">$<?= number_format($averageCost, 2) ?></div>
                <div class="stat-label">Average Cost</div>
            </div>
        </div>

        <!-- Charts -->
        <div class="charts-container">
            <div class="chart-card">
                <canvas id="designDistribution"></canvas>
            </div>
            <div class="chart-card">
                <canvas id="costTrend"></canvas>
            </div>
        </div>

        <!-- Estimates Table -->
        <div class="estimates-table">
            <div class="table-header">
                <div class="table-title">Recent Estimates</div>
                <div class="search-box">
                    <i class="fas fa-search search-icon"></i>
                    <input type="text" class="search-input" placeholder="Search estimates..." id="searchInput">
                </div>
            </div>
            
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>User</th>
                            <th>Yard Size</th>
                            <th>Design Option</th>
                            <th>Estimated Cost</th>
                            <th>Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($estimates as $e): ?>
                            <tr>
                                <td><?= e($e['username']); ?></td>
                                <td><?= e($e['yard_size']); ?> m²</td>
                                <td>
                                    <span class="design-badge design-<?= strtolower($e['design_option']) ?>">
                                        <?= ucfirst(e($e['design_option'])); ?>
                                    </span>
                                </td>
                                <td>$<?= number_format(e($e['estimated_cost']), 2); ?></td>
                                <td>
                                    <span title="<?= e($e['created_at']); ?>">
                                        <?= date('M d, Y', strtotime($e['created_at'])); ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="status-badge <?= strtotime($e['created_at']) > strtotime('-24 hours') ? 'design-minimal' : 'design-moderate' ?>">
                                        <?= strtotime($e['created_at']) > strtotime('-24 hours') ? 'New' : 'Processed' ?>
                                    </span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Time update function with new format
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

    // Search functionality
    const searchInput = document.getElementById('searchInput');
    searchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        const rows = document.querySelectorAll('tbody tr');

        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(searchTerm) ? '' : 'none';
        });
    });

    // Design Distribution Chart
    const designCtx = document.getElementById('designDistribution').getContext('2d');
    new Chart(designCtx, {
        type: 'doughnut',
        data: {
            labels: ['Minimal', 'Moderate', 'Luxury'],
            datasets: [{
                data: [30, 45, 25],
                backgroundColor: [
                    'rgba(52, 152, 219, 0.8)',
                    'rgba(241, 196, 15, 0.8)',
                    'rgba(46, 204, 113, 0.8)'
                ]
            }]
        },
        options: {
            responsive: true,
            plugins: {
                title: {
                    display: true,
                    text: 'Design Options Distribution'
                }
            }
        }
    });

    // Cost Trend Chart
    const costCtx = document.getElementById('costTrend').getContext('2d');
    new Chart(costCtx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
            datasets: [{
                label: 'Average Cost Trend',
                data: [5000, 5500, 4800, 6000, 5800, 6200],
                borderColor: 'rgba(46, 204, 113, 1)',
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            plugins: {
                title: {
                    display: true,
                    text: 'Monthly Cost Trend'
                }
            },
            scales: {
                y: {
                    beginAtZero: false
                }
            }
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
});
</script>

</body>
</html>