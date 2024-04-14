<?php
include '../connections.php';

// Add these lines for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fetch order totals from the order table
$orderTotalsQuery = "SELECT product_id, SUM(quantity) AS total_quantity FROM order_table GROUP BY product_id";
$orderTotalsResult = mysqli_query($conn, $orderTotalsQuery);

if (!$orderTotalsResult) {
    die("Error fetching order totals: " . mysqli_error($conn));
}

// Fetch product names for each product_id
$productNamesQuery = "SELECT product_id, pname FROM tbl_product";
$productNamesResult = mysqli_query($conn, $productNamesQuery);

if (!$productNamesResult) {
    die("Error fetching product names: " . mysqli_error($conn));
}

// Create an associative array to store product names
$productNames = array();

while ($row = mysqli_fetch_assoc($productNamesResult)) {
    $productNames[$row['product_id']] = $row['pname'];
}

// Create an array to store order totals
$orderTotals = array();

while ($row = mysqli_fetch_assoc($orderTotalsResult)) {
    $productId = $row['product_id'];
    $productName = $productNames[$productId];
    $totalQuantity = $row['total_quantity'];

    $orderTotals[] = array(
        'product_id' => $productId,
        'product_name' => $productName,
        'total_quantity' => $totalQuantity
    );
}

// Return the order totals as JSON
echo json_encode($orderTotals);

mysqli_close($conn);
?>
