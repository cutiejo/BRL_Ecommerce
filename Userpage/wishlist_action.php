<?php
include "../connections.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $userId = $_POST['user_id'];
    $productId = $_POST['product_id'];

    // Check if the product is already in the wishlist
    $sql = "SELECT * FROM wishlist WHERE user_id = ? AND product_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $userId, $productId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Product is already in wishlist, remove it
        $sql = "DELETE FROM wishlist WHERE user_id = ? AND product_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $userId, $productId);
        if ($stmt->execute()) {
            echo 'removed';
        } else {
            echo 'error';
        }
    } else {
        // Product is not in wishlist, add it
        $sql = "INSERT INTO wishlist (user_id, product_id) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $userId, $productId);
        if ($stmt->execute()) {
            echo 'added';
        } else {
            echo 'error';
        }
    }
}
?>
