<?php
include '../connections.php';

if (!isset($_GET['user_id'])) {
    echo json_encode(['success' => false, 'debug' => 'User ID not provided']);
    exit();
}

$user_id = $_GET['user_id'];

$query = "SELECT * FROM messages WHERE (user_id = $user_id AND receiver_id = 1) OR (user_id = 1 AND receiver_id = $user_id)";
$result = mysqli_query($conn, $query);

if (!$result) {
    echo json_encode(['success' => false, 'debug' => mysqli_error($conn)]);
    exit();
}

$messages = [];
while ($row = mysqli_fetch_assoc($result)) {
    $messages[] = $row;
}

echo json_encode(['success' => true, 'messages' => $messages]);
?>
