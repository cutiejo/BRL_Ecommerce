<?php
include "../connections.php";

// Start the session
session_start();

// Get the user ID from the session
$user_id = $_SESSION['user_id'];

// Check if the product details are set in POST data
if (isset($_POST['product_ids'])) {
    $product_ids = $_POST['product_ids'];
    $product_names = $_POST['product_names'];
    $product_images = $_POST['product_images'];
    $product_prices = $_POST['product_prices'];
    $quantities = $_POST['quantities'];
    $payment_option = $_POST['payment_option'];

    // Initialize an array to store order details
    $orderDetails = [];

    // Prepare the SQL statement
    $sql = "INSERT INTO tbl_orders (user_id, product_id, product_name, quantity, price, payment_option, order_date) VALUES (?, ?, ?, ?, ?, ?, NOW())";
    $stmt = $conn->prepare($sql);

    // Check if the statement preparation was successful
    if (!$stmt) {
        die("Error preparing SQL statement: " . $conn->error);
    }

    for ($i = 0; $i < count($product_ids); $i++) {
        $product_id = $product_ids[$i];
        $product_name = $product_names[$i];
        $product_image = $product_images[$i];
        $product_price = $product_prices[$i];
        $quantity = $quantities[$i];
        $total_price = $product_price * $quantity;

        $stmt->bind_param("iisids", $user_id, $product_id, $product_name, $quantity, $total_price, $payment_option);

        if ($stmt->execute()) {
            // Add the product details to the order details array
            $orderDetails[] = [
                'product_id' => $product_id,
                'product_name' => $product_name,
                'product_image' => $product_image,
                'product_price' => $product_price,
                'quantity' => $quantity,
                'total_price' => $total_price,
                'payment_option' => $payment_option
            ];
        } else {
            echo "Error executing SQL statement: " . $stmt->error;
        }
    }

    $stmt->close();
    $conn->close();

    // Store the order details in session
    $_SESSION['orderDetails'] = $orderDetails;

    // Redirect to appropriate confirmation page
    if ($payment_option == 'gcash') {
        header("Location: gcash_confirmation.php");
    } else {
        header("Location: order_confirmation.php");
    }
    exit();
} else {
    echo "No product details found.";
}
?>
