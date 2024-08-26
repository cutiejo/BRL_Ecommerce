<?php
include '../connections.php';


    if (isset($_POST['username']) && isset($_POST['useremail']) && isset($_POST['password']) && isset($_POST['role'])) {
        // Add user to the database
       
        $username = $_POST['username'];
        $useremail = $_POST['useremail'];
        $password = $_POST['password'];
        $role = $_POST['role'];


        // Password complexity validation
        if (!preg_match('/^(?=.*[a-zA-Z])(?=.*\d)(?=.*[!@#$%^&*])[A-Za-z\d!@#$%^&*]{8,}$/', $password)) {
            echo json_encode(['error' => 'Password must contain at least one letter, one number, one special character, and be at least 8 characters long.']);
            exit;
        }
    
        $sql = "INSERT INTO users (username, useremail, password, role) VALUES ('$username','$useremail','$password', '$role')";
    
        if ($conn->query($sql) === TRUE) {
            // Return the inserted user data as JSON
            $newUser = [
                'user_id' => $conn->insert_id,
                'username' => $username,
                'useremail' => $useremail,
                'password' => $password,
                'role' => $role,
            ];

            echo json_encode($newUser);
        } else {
            // Return an error message as JSON
            echo json_encode(['error' => 'Error adding user. Please try again.']);
        }
    } elseif (isset($_POST['deleteUserId'])) {
        // Delete user from the database
        $userId = $_POST['deleteUserId'];

        $sql = "DELETE FROM users WHERE user_id = '$userId'";

        if ($conn->query($sql) === TRUE) {
            // Return a success message as JSON
            echo json_encode(['success' => 'User deleted successfully.']);
        } else {
            echo json_encode(['error' => 'Error deleting user. Please try again.']);
        }
    

    // Close connection
    $conn->close();
} else {
    // Fetch users from the database
    $conn = new mysqli($host, $username, $useremail, $password, $database);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM users";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $users = array();

        while ($row = $result->fetch_assoc()) {
            // Add user data to the array
            $users = array(
                'user_id' => $row['user_id'],
                'username' => $row['username'],
                'useremail' => $row['useremail'],
                'password' => $row['password'],
                'role' => $row['role'], // Include the "role" field
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
}

?>