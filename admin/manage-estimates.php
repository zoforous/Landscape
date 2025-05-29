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
    ORDER BY e.created_at DESC
");
$estimates = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Estimates</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>
<body>
<header><h1>Cost Estimates</h1></header>

<main class="container">
    <a href="dashboard.php">← Back to Dashboard</a>
    <table>
        <thead>
            <tr>
                <th>User</th><th>Yard Size</th><th>Design</th><th>Cost</th><th>Date</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($estimates as $e): ?>
                <tr>
                    <td><?= e($e['username']); ?></td>
                    <td><?= e($e['yard_size']); ?> m²</td>
                    <td><?= ucfirst(e($e['design_option'])); ?></td>
                    <td>$<?= e($e['estimated_cost']); ?></td>
                    <td><?= e($e['created_at']); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</main>
</body>
</html>