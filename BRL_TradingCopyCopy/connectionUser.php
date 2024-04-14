<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Database credentials
    $host = "localhost";
    $username = "root"; // Replace with your actual database username
    $password = ""; // Replace with your actual database password
   
    $database = "db_brl";

    // Create connection
    $conn = new mysqli($host, $username, $password, $database);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Get user data from the POST request -------------------------------------
    $username = $_POST['username'];
    $password = $_POST['password'];  
    $role = $_POST['role'];  

    // Insert user into the database -----------------------------------------------
    $sql = "INSERT INTO add_user (name, password,role) VALUES ('$username', '$password' , '$role')";

    if ($conn->query($sql) === TRUE) {
        // Return the inserted user data
        $newUser = [
            'id' => $conn->insert_id,
            'username' => $username,
            'password' => $password,
            'role' => $role,
        ];
        echo json_encode($newUser);
    } else {
        // Return an error message
        echo json_encode(['error' => 'Error adding user. Please try again.']);
    }

    // Close connection
    $conn->close();
}
?>
