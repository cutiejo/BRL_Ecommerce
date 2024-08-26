<?php
include '../connections.php';

$user_id = $_GET['user_id'];

$query = "SELECT * FROM messages WHERE (user_id = ? AND receiver_id = 1) OR (user_id = 1 AND receiver_id = ?) ORDER BY created_at";
$stmt = $conn->prepare($query);
$stmt->bind_param('ii', $user_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();

$messages = [];
while ($row = $result->fetch_assoc()) {
    $messages[] = $row;
}

echo json_encode(['messages' => $messages]);

$stmt->close();
$conn->close();
?>
