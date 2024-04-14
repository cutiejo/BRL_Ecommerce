<?php
include '../connections.php';

if (isset($_GET['id'])) {
    $productId = $_GET['id'];

    // Fetch product details based on the provided product ID
    $query = "SELECT * FROM tbl_product WHERE pid = $productId";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $productDetails = mysqli_fetch_assoc($result);
        echo json_encode($productDetails);
    } else {
        echo json_encode(['error' => 'Product not found']);
    }
} else {
    echo json_encode(['error' => 'Invalid request']);
}
?>
