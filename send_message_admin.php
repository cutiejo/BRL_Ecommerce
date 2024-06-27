<?php
include '../connections.php';

$text = $_POST['text'];
$system = $_POST['system']; // 'A' for admin, 'B' for user

$query = "INSERT INTO messagesc (text, system) VALUES (?, ?)";
$stmt = $conn->prepare($query);
$stmt->bind_param("ss", $text, $system);
$stmt->execute();

$response = array(
    "id" => $stmt->insert_id,
    "text" => $text,
    "created_at" => date("Y-m-d H:i:s"),
    "system" => $system
);

echo json_encode($response);
?>
