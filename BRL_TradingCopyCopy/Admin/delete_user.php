<?php
// Ensure required variables are defined
include '../connections.php';
if (!isset($host, $username, $password, $database)) {
    die("Database connection details are missing. Please define them.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if deleteUserId is set and not empty
    if (isset($_POST['deleteUserId']) && !empty($_POST['deleteUserId'])) {
        $deleteUserId = intval($_POST['deleteUserId']); // Ensure integer value

        // Create connection

        
$conn = new
 
mysqli($host, $username, $password, $database);

        // Check connection

        
if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Prepare and bind the DELETE query
        $sql = "DELETE FROM users WHERE user_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $deleteUserId);

        // Execute the DELETE query
        if ($stmt->execute()) {
            // Send a success JSON response
            header('Content-Type: application/json');
            echo json_encode(['success' => true]);
        } else {
            // Send an error JSON response with more details
            header('Content-Type: application/json');
            echo json_encode(['error' => 'User deletion failed: ' . $stmt->error]); // Use $stmt->error for more specific error
        }

        // Close statement and connection
        $stmt->close();
        $conn->close();
    } else {
        // Invalid request, send an error response
        header('Content-Type: application/json');
        echo json_encode(['error' => 'Invalid request: Missing or empty deleteUserId']);
    }
} else {
    // Invalid request method, send an error response
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Invalid request method']);
}
?>