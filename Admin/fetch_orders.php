<?php
include '../connections.php';
//nagshoshow sa table
// Check if the connection is successful
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Query to fetch order data
$query = "SELECT * FROM tbl_orders"; 

// Execute the query
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Error fetching orders: " . mysqli_error($conn));
}

// Fetch data and store in an array
$orders = array();
while ($row = mysqli_fetch_assoc($result)) {
    $orders[] = $row;
}

// Close the connection
mysqli_close($conn);

// Return the orders data as JSON
echo json_encode($orders);




?>