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
    <title>Manage Contacts</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>
<body>
<header><h1>Contact Submissions</h1></header>

<main class="container">
    <a href="dashboard.php">← Back to Dashboard</a>
    <table>
        <thead>
            <tr>
                <th>Name</th><th>Email</th><th>Phone</th><th>Message</th><th>Date</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($contacts as $c): ?>
                <tr>
                    <td><?= e($c['name']); ?></td>
                    <td><?= e($c['email']); ?></td>
                    <td><?= e($c['phone']); ?></td>
                    <td><?= e($c['message']); ?></td>
                    <td><?= e($c['created_at']); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</main>
</body>
</html>