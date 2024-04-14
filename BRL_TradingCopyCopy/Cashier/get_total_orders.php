<?php
include '../connections.php';

// Check if the connection is successful
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Query to get the total count of orders
$query = "SELECT COUNT(*) as totalOrders FROM tbl_orders";

// Execute the query
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Error fetching total orders count: " . mysqli_error($conn));
}

// Fetch the total orders count
$totalOrdersData = mysqli_fetch_assoc($result);

// Close the connection
mysqli_close($conn);

// Return the total orders count as JSON
echo json_encode($totalOrdersData);
?>
