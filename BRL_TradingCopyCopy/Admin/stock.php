<?php
// Include the database connection
include '../connections.php';


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




//dagdag//

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
// Handle form submission, including image upload
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["addItem"])) {
    // Handle image upload
    $imageDir = "uploads/";
    $imageName = $_FILES["image"]["name"];
    $imagePath = $imageDir . $imageName;
    $tmpFilePath = $_FILES["image"]["tmp_name"];

    // Check if the uploads directory exists, create it if not
    if (!is_dir($imageDir)) {
        mkdir($imageDir, 0777, true);
    }

    if (move_uploaded_file($tmpFilePath, $imagePath)) {
        // File uploaded successfully, continue with other form data processing

        // Retrieve other form data
        $itemName = $_POST["itemName"];
        $category = $_POST["category"];
        $price = $_POST["price"];
        $stock = $_POST["stock"];
        $description = $_POST["description"];

        // Insert data into the database
        $insertSql = "INSERT INTO tbl_product (pname, pimage, pcategory, saleprice, stock_quantity, pdescription) VALUES ('$itemName', '$imagePath', '$category', '$price', '$stock', '$description')";

        if (mysqli_query($conn, $insertSql)) {
            header("Location: product.php");
            exit;
        } else {
            echo "Error: " . $insertSql . "<br>" . mysqli_error($conn);
        }
    } else {
        echo "Error uploading file.";
    }
}

// Handle search form submission

// Handle edit form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["editItem"])) {
    $editProductId = $_POST["editProductId"];

    // Retrieve other form data
    $editItemName = $_POST["editItemName"];
    $editCategory = $_POST["editCategory"];
    $editPrice = $_POST["editPrice"];
    $editStock = $_POST["editStock"];
    $editDescription = $_POST["editDescription"];

    // Check if a new image is uploaded
    if (!empty($_FILES["editImage"]["name"])) {
        $editImageDir = "uploads/";
        $editImageName = $_FILES["editImage"]["name"];
        $editImagePath = $editImageDir . $editImageName;
        $editTmpFilePath = $_FILES["editImage"]["tmp_name"];

        // Move the uploaded file to the uploads directory
        if (move_uploaded_file($editTmpFilePath, $editImagePath)) {
            // Update the database with the new image path
            $updateImageSql = "UPDATE tbl_product SET pimage = '$editImagePath' WHERE pid = $editProductId";
            mysqli_query($conn, $updateImageSql);
        } else {
            echo "Error uploading file.";
        }
    }

    // Update data in the database
    $updateStockQuery = "UPDATE tbl_product SET stock_quantity = '$editStock' WHERE pid = $editProductId";

    if (mysqli_query($conn, $updateStockQuery)) {
        header("Location: product.php");
        exit;
    } else {
        echo "Error: " . $updateStockQuery . "<br>" . mysqli_error($conn);
    }
}    

// Fetch products from the database and populate the table rows
$sql = "SELECT p.*, c.category_name FROM tbl_product p
        JOIN tbl_category c ON p.pcategory = c.category_id";
$result = mysqli_query($conn, $sql);

//



?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <!-- ======= Styles ====== -->
    <link rel="stylesheet" href="./assets/css/style.css">
    <!-- Include the styles and scripts from nav.php -->
    <?php include("nav.php"); ?>
</head>
<style>
    /* Styles for Stock Container */
    .stock-content {
        max-width: 1200px;
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

    .modal-content.small {
    width: 300px;
    
}

.modal-title {
    font-size: 1.2rem;
}

.modal-message {
    font-size: 1rem;
    margin-bottom: 2px;
}

.logout-actions {
    display: flex;
    justify-content: space-between;
}

.logout-btn,
.cancel-btn {
    padding: 8px 16px;
    font-size: 0.9rem;
}
</style>

<body>

      
<!-- ================= Stock Container ================ -->

<!-- Stock Content -->
<div class="stock-content">
    <h2 class="content-header">Stock </h2><br>

    <!-- Add Stock Button -->
    <button id="addStockBtn" class="add-stock-btn" onclick="openModal('addStockModal')"><ion-icon name="add-circle-outline"></ion-icon>Add Stock</button>

    <!-- Stock Table -->
<!-- Stock Table -->
<table id="stockTable">
            <!-- Table headers -->
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Product Name</th>
                    <th>Image</th>
                    <th>Category</th>
                    <th>Sale Price</th>
                    <th>Stock</th>
                    <!--<th>Description</th>-->
                </tr>
            </thead>
            <!-- Table body -->
            <tbody>
                <?php
                // Loop through the product data and display it in the table
                $counter = 1;
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>{$counter}</td>";
                    echo "<td>{$row['pname']}</td>";
                    echo "<td><img src='{$row['pimage']}' alt='Product Image' width='50'></td>";

                    // Check if 'category_name' key exists in the $row array
                    if (isset($row['category_name']) && $row['category_name'] !== null) {
                        echo "<td>{$row['category_name']}</td>";
                    } else {
                        echo "<td>N/A</td>";
                    }

                    echo "<td>{$row['saleprice']}</td>";
                    echo "<td>{$row['stock_quantity']}</td>";
                    /*echo "<td>{$row['pdescription']}</td>";*/

                    



                    echo "</tr>";
                    $counter++;


                }
                ?>
            </tbody>
    <tfoot>
        <tr>
            <td colspan="8">
                <button id="prevPageBtn" disabled>Previous</button>
                <button id="nextPageBtn" disabled>Next</button>
            </td>
        </tr>
    </tfoot>
</table>
<script>
        document.addEventListener("DOMContentLoaded", function () {
            var table = document.querySelector("#stockTable");
            var rows = table.getElementsByTagName("tbody")[0].getElementsByTagName("tr");
            var rowsPerPage = 4; // Updated to display 4 rows per page
            var currentPage = 1;

            function showRows() {
                var start = (currentPage - 1) * rowsPerPage;
                var end = start + rowsPerPage;

                for (var i = 0; i < rows.length; i++) {
                    rows[i].style.display = (i >= start && i < end) ? "" : "none";
                }
            }

            function updatePaginationButtons() {
                var prevButton = document.getElementById("prevPageBtn");
                var nextButton = document.getElementById("nextPageBtn");

                prevButton.disabled = currentPage === 1;
                nextButton.disabled = currentPage === Math.ceil(rows.length / rowsPerPage);
            }

            function changePage(delta) {
                currentPage += delta;
                showRows();
                updatePaginationButtons();
            }

            // Show initial set of rows and update pagination buttons
            showRows();
            updatePaginationButtons();

            // Attach click event listeners to pagination buttons
            document.getElementById("prevPageBtn").addEventListener("click", function () {
                changePage(-1);
            });

            document.getElementById("nextPageBtn").addEventListener("click", function () {
                changePage(1);
            });
        });
    </script>
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

  <!-- =========== Scripts =========  -->  <!-- =========== Scripts =========  -->


    <!-- =========== Scripts =========  -->
    <script src="assets/js/main.js"></script>

    <!-- ======= Charts JS ====== -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.1/dist/chart.min.js"></script>
    <script src="assets/js/chartsJS.js"></script>

    <!-- ====== ionicons ======= -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>

</html>