<?php
include '../connections.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['categoryId'])) {
    $categoryId = $_POST['categoryId'];

    // Perform the deletion in the database
    $deleteSql = "DELETE FROM tbl_category WHERE category_id = ?";
    $stmt = $conn->prepare($deleteSql);
    $stmt->bind_param("i", $categoryId);
    
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Category deleted successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error deleting category']);
    }

    $stmt->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
}
?>
