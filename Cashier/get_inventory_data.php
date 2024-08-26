<?php
// Include the database connection
include '../connections.php';

// Fetch products from the database
$sql = "SELECT p.*, c.category_name FROM tbl_product p
        JOIN tbl_category c ON p.pcategory = c.category_id";
$result = mysqli_query($conn, $sql);

// Check if there are any results
if ($result && mysqli_num_rows($result) > 0) {
    $inventoryData = array();

    while ($row = mysqli_fetch_assoc($result)) {
        // Append each product's data to the array
        $inventoryData[] = array(
            'Product Name' => $row['pname'],
            'Category' => $row['category_name'],
            'Sale Price' => $row['saleprice'],
            'Stock Quantity' => $row['stock_quantity'],
            'Description' => $row['pdescription']
            // Add more fields as needed
        );
    }

    // Return the data as JSON
    header('Content-Type: application/json');
    echo json_encode($inventoryData);
} else {
    // No products found
    header('Content-Type: application/json');
    echo json_encode(array('message' => 'No products found.'));
}

// Close the database connection
mysqli_close($conn);
?>
