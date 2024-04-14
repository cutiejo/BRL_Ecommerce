<?php
include "../connections.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['reset_password'])) {
    // Retrieve the token and new password from the form
    $token = $_POST['token'];
    $newPassword = $_POST['new_password'];

    // Validate token and password (e.g., check for empty fields)

    // Hash the new password before storing it in the database
    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

    // Update the user's password in the database using the token
    $query = "UPDATE users SET password = ? WHERE reset_token = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $hashedPassword, $token);
    $stmt->execute();

    // Check if the password was successfully updated
    if ($stmt->affected_rows > 0) {
        // Password reset successful
        echo "Password reset successful.";
    } else {
        // Password reset failed
        echo "Password reset failed. Invalid token or user.";
    }
}
?>
