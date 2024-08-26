<?php
session_start();
include "../connections.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $useremail = $_POST["useremail"];
    $enteredPassword = $_POST["password"];
    $role = $_POST["role"];

    $query = "SELECT * FROM users WHERE useremail = ? AND role = ?";
    $stmt = $connection->prepare($query);
    $stmt->bind_param("ss", $useremail, $role);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        $storedPassword = $user['password'];

        // Verify the entered password against the stored hashed password
        if (password_verify($enteredPassword, $storedPassword)) {
            echo "true"; // Password is correct
        } else {
            echo "false"; // Password is incorrect
        }
    } else {
        echo "false"; // User not found
    }
}
?>
