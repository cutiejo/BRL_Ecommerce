<?php
// Include the database connection file
include 'connections.php';

// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php'); // Redirect to the login page if not logged in
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['editAccount'])) {
    $userId = $_SESSION['user_id'];

    // You can add more fields as needed for editing account details
    $newUsername = mysqli_real_escape_string($conn, $_POST['editUsername']);
    $newPassword = password_hash($_POST['editPassword'], PASSWORD_DEFAULT);

    // Update user information in the database
    $updateQuery = "UPDATE users SET username = '$newUsername', password = '$newPassword' WHERE id = $userId";

    if (mysqli_query($conn, $updateQuery)) {
        // Redirect to a success page or display a success message
        header('Location: profile.php');
        exit();
    } else {
        echo "Error updating user information: " . mysqli_error($conn);
    }
}
?>
