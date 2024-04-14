<?php
include '../connections.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["productId"])) {
    $productId = $_POST["productId"];

    // Perform the delete operation in the database
    $deleteQuery = "DELETE FROM tbl_product WHERE pid = $productId";
    if (mysqli_query($conn, $deleteQuery)) {
        echo "Product deleted successfully";
    } else {
        echo "Error deleting product: " . mysqli_error($conn);
    }
}
?>
