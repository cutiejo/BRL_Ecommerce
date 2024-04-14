<?php
// Include the database connection
include '../connections.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["editItem"])) {
    $editProductId = $_POST["editProductId"];
    $editItemName = mysqli_real_escape_string($conn, $_POST["editItemName"]);
    $editCategory = mysqli_real_escape_string($conn, $_POST["editCategory"]);
    $editPrice = mysqli_real_escape_string($conn, $_POST["editPrice"]);
    $editStock = mysqli_real_escape_string($conn, $_POST["editStock"]);
    $editDescription = mysqli_real_escape_string($conn, $_POST["editDescription"]);

    // Check if a new image is uploaded
    if (!empty($_FILES["editImage"]["name"])) {
        $editImageDir = "uploads/";
        $editImageName = $_FILES["editImage"]["name"];
        $editImagePath = $editImageDir . $editImageName;
        $editTmpFilePath = $_FILES["editImage"]["tmp_name"];

        if (move_uploaded_file($editTmpFilePath, $editImagePath)) {
            // Update the database with the new image path
            $updateImageSql = "UPDATE tbl_product SET pimage = '$editImagePath' WHERE pid = $editProductId";
            mysqli_query($conn, $updateImageSql);
        } else {
            // Log the error and handle accordingly
            error_log("Error uploading file in update_product.php: " . mysqli_error($conn), 0);
            header("Location: product.php?error=image_upload_error");
            exit;
        }
    }

    // Update data in the database (tbl_product table)
    $updateProductQuery = "UPDATE tbl_product SET pname = '$editItemName', pcategory = '$editCategory', saleprice = '$editPrice', stock_quantity = '$editStock', pdescription = '$editDescription' WHERE pid = $editProductId";

    // Update stock quantity in the stock table
    $updateStockQuery = "UPDATE stock SET stock_quantity = '$editStock' WHERE product_id = $editProductId";

    if (mysqli_query($conn, $updateProductQuery) && mysqli_query($conn, $updateStockQuery)) {
        header("Location: product.php");
        exit;
    } else {
        // Log the error to a file for debugging purposes
        error_log("Error updating product or stock in update_product.php: " . mysqli_error($conn), 0);

        // You can also redirect back to the product.php page with an error parameter
        header("Location: product.php?error=update_error");
        exit;
    }
}
?>
