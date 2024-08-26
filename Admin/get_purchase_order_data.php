<?php
// Include the database connection
include '../connections.php';

// Add these lines for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Prepare and execute the query to fetch purchase order data
$selectQuery = "SELECT * FROM tbl_orders";
$result = mysqli_query($conn, $selectQuery);

// Check for errors in executing the query
if (!$result) {
    die("Error fetching purchase order data: " . mysqli_error($conn));
}

// Fetch the purchase order data
$purchaseOrderData = array();
while ($row = mysqli_fetch_assoc($result)) {
    $purchaseOrderData[] = $row;
}

// Convert the result to JSON and echo it
echo json_encode($purchaseOrderData);

// Close the database connection
mysqli_close($conn);
?>
