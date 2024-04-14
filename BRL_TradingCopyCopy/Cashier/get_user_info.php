<?php
// Include your database connection file
include '../connections.php';


// Check if the user is logged in
if (isset($_SESSION['user_id'])) {
    // Fetch user details from the database
    $userId = $_SESSION['user_id'];
    $query = "SELECT username FROM users WHERE id = $userId";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $userData = mysqli_fetch_assoc($result);
        $username = $userData['username'];
        echo "<p>Hi, $username!</p>";
    } else {
        echo "<p>Error fetching user information.</p>";
    }
} else {
    echo "<p>User not logged in.</p>";
}
?>
