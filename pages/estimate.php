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
    <title>Project Cost Estimator</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
    <script defer src="../assets/js/scripts.js"></script>
</head>
<body>

<header><h1>Project Cost Estimator</h1></header>

<main class="container">
    <form method="POST" id="estimateForm">
        <label for="yard_size">Yard Size (m²):</label>
        <input type="number" name="yard_size" id="yard_size" required>

        <label for="design_option">Design Option:</label>
        <select name="design_option" id="design_option" required>
            <option value="basic">Basic ($5/m²)</option>
            <option value="premium">Premium ($10/m²)</option>
            <option value="luxury">Luxury ($15/m²)</option>
        </select>

        <p>Estimated Cost: <span id="result">$0.00</span></p>
        <button type="submit">Submit Estimate</button>
    </form>
</main>

<script>
document.getElementById('estimateForm').addEventListener('input', () => {
    const size = parseFloat(document.getElementById('yard_size').value) || 0;
    const type = document.getElementById('design_option').value;
    const rate = { basic: 5, premium: 10, luxury: 15 }[type];
    document.getElementById('result').textContent = '$' + (size * rate).toFixed(2);
});
</script>

</body>
</html>
