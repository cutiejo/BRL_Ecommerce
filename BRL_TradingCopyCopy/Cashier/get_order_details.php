<?php
include '../connections.php';

// Assuming that the order ID is passed through the query string
if (isset($_GET['orderId'])) {
    $orderId = $_GET['orderId'];

    // Perform a query to fetch order details
    $orderDetailsSql = "SELECT * FROM tbl_orders WHERE order_id = ?";
    $stmt = mysqli_prepare($conn, $orderDetailsSql);
    mysqli_stmt_bind_param($stmt, "i", $orderId);

    if (mysqli_stmt_execute($stmt)) {
        // Fetch the result and send it as JSON
        $result = mysqli_stmt_get_result($stmt);
        $orderDetails = mysqli_fetch_assoc($result);

        // Send order details as JSON
        header('Content-Type: application/json');
        echo json_encode($orderDetails);
    } else {
        // Handle the error
        header('Content-Type: application/json');
        echo json_encode(['error' => 'Failed to fetch order details']);
    }

    // Close the statement
    mysqli_stmt_close($stmt);
} else {
    // Handle the case where orderId is not set in the query string
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Order ID not provided']);
}

// Close the database connection
mysqli_close($conn);
?>
