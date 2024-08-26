<?php
include "../connections.php";

// Start the session
session_start();

// Get the search query
$query = isset($_GET['query']) ? $_GET['query'] : '';

// Fetch products from the database matching the search query
$sql = "SELECT * FROM tbl_product WHERE pname LIKE '%$query%' OR pdescription LIKE '%$query%'";
$result = $conn->query($sql);

$products = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
}

// Return the filtered products as HTML
foreach ($products as $product) {
    echo '<div class="dropdown-item" onclick="selectProduct(' . $product['pid'] . ')">';
    echo '<img src="../Admin/' . $product['pimage'] . '" alt="' . $product['pname'] . '" style="width: 50px; height: 50px;">';
    echo '<span>' . $product['pname'] . '</span>';
    echo '</div>';
}
?>
