<?php
include '../connections.php';

session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../LOGIN/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$sql = "SELECT messages.*, 
               CASE 
                   WHEN messages.user_id = '$user_id' THEN (SELECT username FROM users WHERE user_id = messages.receiver_id)
                   ELSE (SELECT username FROM users WHERE user_id = messages.user_id)
               END AS chat_with 
        FROM messages 
        WHERE (messages.user_id = '$user_id' AND messages.receiver_id = 1) 
        OR (messages.user_id = ? AND messages.receiver_id = '$user_id') 
        ORDER BY created_at ASC";

$result = mysqli_query($conn, $sql);

$messages = [];
while ($row = mysqli_fetch_assoc($result)) {
    $messages[] = $row;
}

echo json_encode(['messages' => $messages]);
?>
