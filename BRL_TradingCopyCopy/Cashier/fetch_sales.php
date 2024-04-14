<?php
include '../connections.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if the request is an AJAX request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['fromDate']) && isset($_POST['toDate'])) {
    // Sanitize input
    $fromDate = mysqli_real_escape_string($conn, $_POST['fromDate']);
    $toDate = mysqli_real_escape_string($conn, $_POST['toDate']);

    // Query to fetch sales data based on the selected date range
    $query = "SELECT product_name, order_date, quantity, price FROM tbl_orders WHERE order_date BETWEEN '$fromDate' AND '$toDate'";
    $result = mysqli_query($conn, $query);

    // Check if the query was successful
    if ($result) {
        $salesData = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $salesData[] = $row;
        }
        // Encode the sales data as JSON and send it back to the client
        echo json_encode($salesData);
        exit;
    } else {
        // Handle query error
        echo "Error fetching sales data: " . mysqli_error($conn);
        exit;
    }
}
?>
