<?php
include '../connections.php';

$user_id = $_GET['user_id'];

$query = "SELECT username FROM users WHERE user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$stmt->bind_result($username);
$stmt->fetch();

echo json_encode(['username' => $username]);

$stmt->close();
$conn->close();
?>
