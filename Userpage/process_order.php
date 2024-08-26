<?php
include "../connections.php";

// Start the session
session_start();

// Fetch the order details from the POST request
$user_id = $_SESSION['user_id'];
$product_id = $_POST['product_id'];
$product_name = $_POST['product_name'];
$product_price = $_POST['product_price'];
$quantity = $_POST['quantity'];
$grandTotal = $_POST['grandTotal'];
$shippingCost = $_POST['shippingCost'];
$totalPayment = $_POST['totalPayment'];

// Insert order details into the database
$sql = "INSERT INTO tbl_orders (user_id, product_id, product_name, product_price, quantity, grand_total, shipping_cost, total_payment)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("Query preparation failed: " . $conn->error);
}
$stmt->bind_param("iisdiidd", $user_id, $product_id, $product_name, $product_price, $quantity, $grandTotal, $shippingCost, $totalPayment);
if ($stmt->execute()) {
    // Redirect to order confirmation page
    header("Location: order_confirmation.php");
} else {
    die("Order processing failed: " . $stmt->error);
}
$stmt->close();
$conn->close();
?>
