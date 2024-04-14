<?php
include '../connections.php';

// Add these lines for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if the order_id is provided
if (!isset($_POST['order_id'])) {
    die(json_encode(["error" => "Order ID not provided"]));
}

// Sanitize the input
$order_id = mysqli_real_escape_string($conn, $_POST['order_id']);

// Perform the deletion
$deleteQuery = "DELETE FROM tbl_orders WHERE order_id = '$order_id'";
$deleteResult = mysqli_query($conn, $deleteQuery);

if ($deleteResult) {
    echo json_encode(["success" => true, "message" => "Order deleted successfully"]);
} else {
    echo json_encode(["success" => false, "message" => "Error deleting order: " . mysqli_error($conn)]);
}

// Close the connection
mysqli_close($conn);
?>
