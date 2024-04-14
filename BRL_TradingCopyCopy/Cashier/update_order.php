<?php
include '../connections.php';

// Add these lines for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve data from the form
    $orderId = $_POST['editOrderId'];
    $orderDate = $_POST['editOrderDate'];
    $quantity = $_POST['editQuantity'];

    // Perform any necessary validation on the received data

    // Update the order in the database
    $updateOrderQuery = "UPDATE tbl_orders SET order_date = '$orderDate', quantity = $quantity WHERE order_id = $orderId";

    if (mysqli_query($conn, $updateOrderQuery)) {
        // Update successful, you can perform any additional actions here
        echo "Order updated successfully";
    } else {
        // Update failed, handle the error (e.g., log it or display a message)
        echo "Error updating order: " . mysqli_error($conn);
    }

    // Close the database connection
    mysqli_close($conn);
}
?>
