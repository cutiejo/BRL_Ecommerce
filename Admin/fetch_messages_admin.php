<?php
include '../connections.php';

$user_id = $_GET['user_id'];

$query = "SELECT messages.*, 
                 CASE 
                     WHEN messages.user_id = '$user_id' THEN (SELECT username FROM users WHERE user_id = messages.receiver_id)
                     ELSE (SELECT username FROM users WHERE user_id = messages.user_id)
                 END AS chat_with 
          FROM messages 
          WHERE (messages.user_id = '$user_id' AND messages.receiver_id = 1) 
          OR (messages.user_id = 1 AND messages.receiver_id = '$user_id') 
          ORDER BY created_at ASC";

$result = mysqli_query($conn, $query);

$messages = [];
while ($row = mysqli_fetch_assoc($result)) {
    $messages[] = $row;
}

echo json_encode(['messages' => $messages, 'query' => $query, 'debug_user_id' => $user_id]);
?>
