<?php
include "../connections.php";

// Start the session
session_start();

// Get the user ID from the session
$user_id = $_SESSION['user_id'];
$order_id = $_POST['order_id'];

// Handle the file upload for GCash proof of payment
if (isset($_FILES['proof_of_payment']) && $_FILES['proof_of_payment']['error'] == 0) {
    $upload_dir = '../uploads/proof_of_payment/';
    $proof_of_payment_path = $upload_dir . basename($_FILES['proof_of_payment']['name']);
    if (move_uploaded_file($_FILES['proof_of_payment']['tmp_name'], $proof_of_payment_path)) {
        $proof_of_payment_path = htmlspecialchars($proof_of_payment_path);

        // Update the order with the proof of payment path
        $sql = "UPDATE tbl_orders SET proof_of_payment_path = ?, gcash_message = ? WHERE order_id = ?";
        $stmt = $conn->prepare($sql);
        $gcash_message = htmlspecialchars($_POST['gcash_message']);
        $stmt->bind_param("ssi", $proof_of_payment_path, $gcash_message, $order_id);
        $stmt->execute();
        $stmt->close();

        // Redirect to order confirmation page
        header("Location: order_confirmation.php?order_id=" . $order_id);
        exit();
    }
}

echo "Failed to upload proof of payment.";
?>
