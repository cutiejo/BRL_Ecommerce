<?php
// Simulating notifications
$notifications = array(
    array('type' => 'success', 'message' => 'Inventory levels are normal.'),
    array('type' => 'error', 'message' => 'System update scheduled for tomorrow.'),
    // Add more notifications as needed
);

foreach ($notifications as $notification) {
    echo '<div class="notification alert alert-' . $notification['type'] . '">';
    echo $notification['message'];
    echo '</div>';
}
?>
