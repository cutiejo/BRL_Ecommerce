<?php
include '../connections.php';
//fix na
// Add these lines for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

try {
    if (!$conn) {
        throw new Exception("Connection failed: " . mysqli_connect_error());
    }

    // Get the product name from the URL parameter
    $productName = isset($_GET['pname']) ? $_GET['pname'] : '';

    if (empty($productName)) {
        throw new Exception("Product name is required.");
    }

    // Fetch product details from the database
    $productDetailsQuery = "SELECT saleprice, stock_quantity FROM tbl_product WHERE pname = ?";
    $productDetailsStmt = mysqli_prepare($conn, $productDetailsQuery);

    if (!$productDetailsStmt) {
        throw new Exception("Error preparing product details query: " . mysqli_error($conn));
    }

    mysqli_stmt_bind_param($productDetailsStmt, "s", $productName);
    mysqli_stmt_execute($productDetailsStmt);

    $productDetailsResult = mysqli_stmt_get_result($productDetailsStmt);

    if (mysqli_num_rows($productDetailsResult) == 1) {
        // Fetch product details
        $productDetails = mysqli_fetch_assoc($productDetailsResult);

        // Return product details as JSON
        http_response_code(200);
        echo json_encode($productDetails);
    } else {
        // Product not found
        http_response_code(404);
        echo json_encode(["error" => "Product not found."]);
    }

    mysqli_stmt_close($productDetailsStmt);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(["error" => $e->getMessage()]);
} finally {
    // Close the database connection
    mysqli_close($conn);
}
?>
