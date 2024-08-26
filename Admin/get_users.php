<?php
include '../connections.php';

// SQL query to fetch users with both 'admin' and 'cashier' roles
$query = "SELECT * FROM users WHERE FIND_IN_SET('admin', roles) AND FIND_IN_SET('cashier', roles)";
$result = $conn->query($query);

$users = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }
}

echo json_encode($users);
?>
