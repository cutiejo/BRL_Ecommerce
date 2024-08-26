<?php
include '../connections.php';

$response = array('success' => false);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $userId = $_POST['user_id'];
    $message = $_POST['message'];

    // Ensure user_id and message are valid
    if (!empty($userId) && !empty($message)) {
        $query = "INSERT INTO messages (user_id, receiver_id, message, created_at) VALUES (?, ?, ?, NOW())";
        $stmt = $conn->prepare($query);
        $receiverId = 1; // Assuming 1 is the admin ID
        $stmt->bind_param("iis", $userId, $receiverId, $message);

        if ($stmt->execute()) {
            $response['success'] = true;
        } else {
            $response['error'] = $stmt->error;
        }

        $stmt->close();
    } else {
        $response['error'] = 'User ID or message is empty.';
    }
} else {
    $response['error'] = 'Invalid request method.';
}

echo json_encode($response);

$conn->close();
?>
