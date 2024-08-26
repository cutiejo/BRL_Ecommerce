<?php
session_start();
include '../connections.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'error' => 'User not logged in']);
    exit();
}

$user_id = $_SESSION['user_id'];
$message = $_POST['message'];
$receiver_id = 1; // Assuming 1 is the admin's ID

if (empty($message) && empty($_FILES['file'])) {
    echo json_encode(['success' => false, 'error' => 'Invalid input']);
    exit();
}

$file_path = null;

if (!empty($_FILES['file']['name'])) {
    $target_dir = "../uploads/";
    $target_file = $target_dir . basename($_FILES['file']['name']);
    if (move_uploaded_file($_FILES['file']['tmp_name'], $target_file)) {
        $file_path = $target_file;
    } else {
        echo json_encode(['success' => false, 'error' => 'File upload error']);
        exit();
    }
}

$sql = "INSERT INTO messages (user_id, receiver_id, message, file, created_at) VALUES ('$user_id', '$receiver_id', '$message', '$file_path', NOW())";

if (mysqli_query($conn, $sql)) {
    echo json_encode(['success' => true, 'message' => $message, 'file' => $file_path, 'created_at' => date('Y-m-d H:i:s')]);
} else {
    echo json_encode(['success' => false, 'error' => mysqli_error($conn)]);
}
?>
