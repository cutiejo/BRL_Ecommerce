<?php
include "../connections.php";
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];
    
    if ($user_id && $product_id && $quantity) {
        // Check if the product is already in the cart
        $sql = "SELECT * FROM tbl_cart WHERE user_id = ? AND product_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $user_id, $product_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            // Update quantity if the product is already in the cart
            $row = $result->fetch_assoc();
            $new_quantity = $row['quantity'] + $quantity;
            $sql = "UPDATE tbl_cart SET quantity = ? WHERE user_id = ? AND product_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("iii", $new_quantity, $user_id, $product_id);
            $stmt->execute();
        } else {
            // Insert new product into the cart
            $sql = "INSERT INTO tbl_cart (user_id, product_id, quantity) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("iii", $user_id, $product_id, $quantity);
            $stmt->execute();
        }
        $stmt->close();
    }
    header("Location: view_cart.php");
    exit;
}
?>
