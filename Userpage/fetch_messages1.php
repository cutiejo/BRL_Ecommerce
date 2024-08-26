<?php
include '../connections.php';

session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../LOGIN/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$sql = "SELECT messages.*, users.username FROM messages 
        LEFT JOIN users ON users.user_id = IF(messages.user_id = '$user_id', messages.receiver_id, messages.user_id)
        WHERE (messages.user_id = '$user_id' AND messages.receiver_id = 1) 
        OR (messages.user_id = 1 AND messages.receiver_id = '$user_id') 
        ORDER BY created_at ASC";
$result = mysqli_query($conn, $sql);

$messages = [];
while ($row = mysqli_fetch_assoc($result)) {
    $messages[] = $row;
}

echo json_encode(['messages' => $messages]);
?>
