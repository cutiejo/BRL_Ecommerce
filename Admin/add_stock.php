<?php
// Include the database connection
include '../connections.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["addStock"])) {
    // Get the product ID and stock quantity from the form
    $productId = $_POST["productSelect"];
    $stockQuantity = $_POST["stockQuantity"];

    // Update the stock table
    $updateStockQuery = "UPDATE stock SET stock_quantity = stock_quantity + $stockQuantity WHERE product_id = $productId";
    $updateStockResult = mysqli_query($conn, $updateStockQuery);

    // Check if the update was successful
    if (!$updateStockResult) {
        die("Error updating stock: " . mysqli_error($conn));
    }

    // Update the product table with the exact stock quantity entered by the user
    $updateProductQuery = "UPDATE tbl_product SET stock_quantity = $stockQuantity WHERE pid = $productId";
    $updateProductResult = mysqli_query($conn, $updateProductQuery);

    // Check if the update was successful
    if (!$updateProductResult) {
        die("Error updating product stock: " . mysqli_error($conn));
    }

    // Redirect to the stock.php page after successful update
    header("Location: stock.php");
    exit();
} else {
    // Redirect to the stock.php page if the form was not submitted
    header("Location: stock.php");
    exit();
}
?>