<?php
// Database credentials
include '../connections.php';

// Fetch users from the database
$sql = "SELECT * FROM users";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $users = array();

    while ($row = $result->fetch_assoc()) {
        // Add user data to the array
        $user = array(
            'user_id' => $row['user_id'],
            'username' => $row['username'],
            'useremail' => $row['useremail'],
            'password' => $row['password'],
            'role' => $row['role'], 
        );
        $users[] = $user;
    }

    // Output users as JSON
    echo json_encode($users);
} else {
    echo "No results in the database";
}

// Close connection
$conn->close();
?>