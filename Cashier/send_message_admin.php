<?php
include '../connections.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $message = $_POST['message'];
    $user_id = $_POST['user_id']; // This is the receiver user ID
    $admin_id = 1; // Assuming admin's user ID is 1

    $query = "INSERT INTO messages (user_id, receiver_id, message) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('iis', $admin_id, $user_id, $message);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => $message, 'created_at' => date('Y-m-d H:i:s')]);
    } else {
        echo json_encode(['success' => false, 'debug' => $stmt->error]);
    }

    $stmt->close();
    $conn->close();
}
?>
