<?php
include '../connections.php';

// Check if the request is an AJAX request
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Query to fetch total sales data
    $query = "SELECT SUM(price) as totalSales FROM tbl_orders";
    $result = mysqli_query($conn, $query);

    // Check if the query was successful
    if ($result) {
        $totalSales = mysqli_fetch_assoc($result)['totalSales'];
        // Encode the total sales data as JSON and send it back to the client
        echo json_encode($totalSales);
        exit;
    } else {
        // Handle query error
        echo "Error fetching total sales data: " . mysqli_error($conn);
        exit;
    }
}

// At the end of your PHP script, add error handling
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
} else {
    // Your existing code for fetching sales data

    // Return the data as JSON
    header('Content-Type: application/json');
    echo json_encode($SalesData); // Replace $yourSalesData with your actual data variable
}
?>
