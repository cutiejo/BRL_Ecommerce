<?php
// Include the database connection
include("../connections.php");

// Fetch recent user data from the database
$recentUsersQuery = "SELECT * FROM users ORDER BY user_id DESC LIMIT 5"; // Assuming tbl_users is your users table
$recentUsersResult = mysqli_query($conn, $recentUsersQuery);

$users = array();

if ($recentUsersResult && mysqli_num_rows($recentUsersResult) > 0) {
    while ($userData = mysqli_fetch_assoc($recentUsersResult)) {
        $users[] = $userData;
    }
}

// Return the recent user data as JSON
header('Content-Type: application/json');
echo json_encode($users);
?>
