<?php
// Include the database connection
include '../connections.php';

Include "assets/js/main.js"; 

// Include the HTML header
include 'header.php';

include 'add_stock.php';


// Fetch data from tbl_product and tbl_stock tables with a JOIN operation
$query = "SELECT p.*, s.stock_quantity, c.category_name
          FROM tbl_product p
          LEFT JOIN stock s ON p.pid = s.product_id
          LEFT JOIN tbl_category c ON p.pcategory = c.category_id";


$result = mysqli_query($conn, $query);

// Check if the query was successful
if (!$result) {
    die("Error in query: " . mysqli_error($conn));
}

// Fetch products for the dropdown
$productQuery = "SELECT pid, pname FROM tbl_product";
$productResult = mysqli_query($conn, $productQuery);

// Check if the query was successful
if (!$productResult) {
    die("Error in query: " . mysqli_error($conn));
}


?>


<style>
    /* Styles for Stock Container */
    .stock-content {
        max-width: 1000px;
        margin: 20px auto;
        background-color: white;
        padding: 20px;
        border: 1px solid #ccc;
        border-radius: 8px;
        width: 100%;
        overflow: auto;
    }

    .content-header {
        font-size: 24px;
        margin-bottom: 10px;
    }

    .add-stock-btn {
        background-color: #4CAF50;
        color: white;
        padding: 10px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 16px;
    }

    .add-stock-btn ion-icon {
        margin-right: 5px;
    }

    #stockTable {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    #stockTable th, #stockTable td {
        border: 1px solid #ddd;
        padding: 12px;
        text-align: left;
    }

    #stockTable th {
        background-color: #33394a;
        color: white;
    }

    #stockTable tbody tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    #stockTable tbody tr:hover {
        background-color: #e0e0e0;
    }
</style>





<!-- Add Stock Modal -->
<div id="addStockModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal('addStockModal')">&times;</span>
        <h2>Add Stock</h2>

        <!-- Add Stock Form -->
<!-- Add Stock Form -->
<form id="addStockForm" action="add_stock.php" method="POST">
    <div class="form-group">
        <label for="productSelect">Select Product:</label>
        <select id="productSelect" name="productSelect">
            <!-- Populate this dropdown with product names from the database -->
            <?php
            // Loop through the product results to populate the dropdown
            while ($productRow = mysqli_fetch_assoc($productResult)) {
                // Display the product name in each option
                echo "<option value='{$productRow['pid']}'>{$productRow['pname']}</option>";
            }
            ?>
        </select>
    </div>
    <div class="form-group">
        <label for="stockQuantity">Stock Quantity:</label>
        <input type="number" id="stockQuantity" name="stockQuantity" placeholder="Enter stock quantity" required>
    </div>
    <button type="submit" name="addStock">Add Stock</button>
</form>

    </div>
</div>
