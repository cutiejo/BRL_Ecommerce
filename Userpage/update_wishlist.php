<?php
include "../connections.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    session_start();

    if (!isset($_SESSION['user_id'])) {
        echo json_encode(['success' => false, 'message' => 'User not logged in']);
        exit;
    }

    $action = $_POST['action'];
    $product_id = $_POST['product_id'];
    $user_id = $_SESSION['user_id'];

    if ($action == 'add') {
        $sql = "INSERT INTO wishlist (user_id, product_id) VALUES (?, ?)";
    } else {
        $sql = "DELETE FROM wishlist WHERE user_id = ? AND product_id = ?";
    }

    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        echo json_encode(['success' => false, 'message' => 'Failed to prepare statement']);
        exit;
    }

    $stmt->bind_param("ii", $user_id, $product_id);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to execute statement']);
    }

    $stmt->close();
    $conn->close();
}
?>
