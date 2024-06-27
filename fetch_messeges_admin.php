<?php
include '../connections.php';

$query = "SELECT * FROM messagesc ORDER BY created_at ASC";
$result = $conn->query($query);

$messages = array();
while($row = $result->fetch_assoc()) {
    $messages[] = $row;
}

echo json_encode($messages);
?>
