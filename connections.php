
<?php
// Database credentials
$host = "localhost"; 
$username = "root";
$password = "";
$database = "db_brl_new";

// Create connection
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Optionally, you can set the character set for the connection
mysqli_set_charset($conn, "utf8");



?>
