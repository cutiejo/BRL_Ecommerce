<?php
include "../connections.php";
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cart_id = $_POST['cart_id'];

    $sql = "DELETE FROM tbl_cart WHERE cart_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $cart_id);
    $stmt->execute();
    $stmt->close();
}
?>
