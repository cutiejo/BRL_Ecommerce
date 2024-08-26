<?php
include '../connections.php';

// Fetch product names from tbl_product
$productsQuery = "SELECT pname FROM tbl_product";
$productsResult = mysqli_query($conn, $productsQuery);

if (!$productsResult) {
    die("Error fetching products: " . mysqli_error($conn));
}

// Store product names in an array
$productNames = array();
while ($row = mysqli_fetch_assoc($productsResult)) {
    $productNames[] = $row['pname'];
}

// Return product names as JSON
echo json_encode($productNames);

mysqli_close($conn);
?>
