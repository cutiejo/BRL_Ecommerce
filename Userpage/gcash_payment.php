<?php
session_start();
if (!isset($_SESSION['orderDetails'])) {
    header("Location: index.php");
    exit();
}

$orderDetails = $_SESSION['orderDetails'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GCash Payment Confirmation</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>GCash Payment Confirmation</h2>
        <p>Your order has been placed. Please send your GCash payment proof to our messaging system.</p>
        <a href="message1.php">Go to Messaging</a>
    </div>
</body>
</html>
