<?php
include "../connections.php";
session_start();

$user_id = $_SESSION['user_id'];
$product_id = isset($_POST['product_id']) ? $_POST['product_id'] : null;

if ($user_id && $product_id) {
    // Remove the product from the wishlist
    $sql = "DELETE FROM wishlist WHERE user_id = ? AND product_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $user_id, $product_id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo 'success';
    } else {
        echo 'error';
    }
    $stmt->close();
}
$conn->close();
?>
