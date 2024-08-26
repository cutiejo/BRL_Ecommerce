<?php
include '../connections.php';

// Add these lines for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

try {
    if (!$conn) {
        throw new Exception("Connection failed: " . mysqli_connect_error());
    }

    // Get values from the form
    $productName = $_POST['productName'];
    $orderDate = $_POST['orderDate'];
    $quantity = $_POST['quantity'];
    $salePrice = $_POST['salePrice'];

    // Assuming you have a column named 'pname' in your tbl_product table
    $productIdQuery = "SELECT pname, stock_quantity FROM tbl_product WHERE pname = ?";

    $productIdStmt = mysqli_prepare($conn, $productIdQuery);

    if (!$productIdStmt) {
        throw new Exception("Error preparing product name query: " . mysqli_error($conn));
    }

    mysqli_stmt_bind_param($productIdStmt, "s", $productName);
    mysqli_stmt_execute($productIdStmt);

    $productIdResult = mysqli_stmt_get_result($productIdStmt);

    if (mysqli_num_rows($productIdResult) == 0) {
        throw new Exception("Product with name '$productName' does not exist.");
    }

    // Fetch product details
    $productDetails = mysqli_fetch_assoc($productIdResult);
    $currentStock = $productDetails['stock_quantity'];

    // Check if there is enough stock
    if ($currentStock < $quantity) {
        throw new Exception("Not enough stock available.");
    }

    // Calculate total based on quantity and sale price
    $total = $quantity * $salePrice;

    // Insert order into the database using prepared statement
    $insertOrderQuery = "INSERT INTO tbl_orders (product_name, order_date, quantity, price)
                        VALUES (?, ?, ?, ?)";

    $insertOrderStmt = mysqli_prepare($conn, $insertOrderQuery);

    // Check if the prepare statement is successful
    if ($insertOrderStmt) {
        mysqli_stmt_bind_param($insertOrderStmt, "ssdd", $productName, $orderDate, $quantity, $total);

        if (mysqli_stmt_execute($insertOrderStmt)) {
            // Order added successfully

            // Update stock in tbl_product
            $newStock = $currentStock - $quantity;
            $updateStockQuery = "UPDATE tbl_product SET stock_quantity = ? WHERE pname = ?";
            $updateStockStmt = mysqli_prepare($conn, $updateStockQuery);
            mysqli_stmt_bind_param($updateStockStmt, "is", $newStock, $productName);
            mysqli_stmt_execute($updateStockStmt);

            http_response_code(200);
            echo json_encode(["success" => true, "message" => "Purchase order added successfully"]);
        } else {
            // Error inserting order
            http_response_code(500);
            echo json_encode(["success" => false, "message" => "Error adding order: " . mysqli_error($conn)]);
        }

        mysqli_stmt_close($insertOrderStmt);
    } else {
        // Error in prepare statement
        throw new Exception("Error preparing statement: " . mysqli_error($conn));
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(["success" => false, "message" => $e->getMessage()]);
} finally {
    // Close the database connection
    mysqli_close($conn);
}
?>
