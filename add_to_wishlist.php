<?php
session_start();
include '../connections.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../LOGIN/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];


$product_id = isset($_POST['product_id']) ? $_POST['product_id'] : null;

if ($user_id && $product_id) {
    // Check if the product is already in the wishlist
    $sql = "SELECT * FROM wishlist WHERE user_id = ? AND product_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $user_id, $product_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo 'exists';
    } else {
        // Add the product to the wishlist
        $sql = "INSERT INTO wishlist (user_id, product_id) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $user_id, $product_id);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            echo 'success';
        } else {
            echo 'error';
        }
    }
    $stmt->close();
}
$conn->close();
?>
