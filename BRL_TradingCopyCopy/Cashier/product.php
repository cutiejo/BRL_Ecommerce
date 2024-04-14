<?php
// Include the database connection
include '../connections.php';

// Fetch data from tbl_product and tbl_stock tables with a JOIN operation
$query = "SELECT p.*, s.stock_quantity, c.category_name
          FROM tbl_product p
          LEFT JOIN stock s ON p.pid = s.product_id
          LEFT JOIN tbl_category c ON p.pcategory = c.category_id";

$result = mysqli_query($conn, $query);

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
if (!empty($editStock)) {
    $updateStockQuery = "UPDATE tbl_product SET stock_quantity = '$editStock' WHERE pid = $editProductId";

    // Check if $editStock is not empty before executing the query
    if (mysqli_query($conn, $updateStockQuery)) {
        header("Location: product.php");
        exit;
    } else {
        echo "Error updating product: " . mysqli_error($conn);
    }
} else {
    echo "Error updating product: Stock quantity cannot be empty.";
}



}


// Handle form submission, including image upload
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["addItem"])) {
        handleAddProduct($conn);
    } elseif (isset($_POST["searchBtn"])) {
        handleSearch($conn);
    } elseif (isset($_POST["editItem"])) {
        handleEditProduct($conn);
    }
}

// Function to handle product addition
function handleAddProduct($conn) {
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

// Function to handle search
function handleSearch($conn) {
    $searchInput = isset($_POST['searchInput']) ? mysqli_real_escape_string($conn, $_POST['searchInput']) : '';

    $query = "SELECT p.*, s.stock_quantity, c.category_name
              FROM tbl_product p
              LEFT JOIN stock s ON p.pid = s.product_id
              LEFT JOIN tbl_category c ON p.pcategory = c.category_id
              WHERE p.pname LIKE '%$searchInput%'
                 OR c.category_name LIKE '%$searchInput%'
                 OR p.saleprice LIKE '%$searchInput%'
                 OR p.stock_quantity LIKE '%$searchInput%'
                 OR p.pdescription LIKE '%$searchInput%'";

    $result = mysqli_query($conn, $query);
}

// Function to handle product editing
// Function to handle product editing
function handleEditProduct($conn) {
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
            echo "Error uploading file.";
        }
    }

    // Update other product details
    $updateProductQuery = "UPDATE tbl_product SET pname = '$editItemName', pcategory = '$editCategory', saleprice = '$editPrice', stock_quantity = '$editStock', pdescription = '$editDescription' WHERE pid = $editProductId";

    if (mysqli_query($conn, $updateProductQuery)) {
        header("Location: product.php");
        exit;
    } else {
        echo "Error updating product: " . mysqli_error($conn);
    }
}



// Fetch products from the database and populate the table rows
$sql = "SELECT p.*, c.category_name FROM tbl_product p
        JOIN tbl_category c ON p.pcategory = c.category_id";
$result = mysqli_query($conn, $sql);


?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cashier</title>
    <!-- ======= Styles ====== -->
    <link rel="stylesheet" href="./assets/css/style.css">
    <!-- Include the styles and scripts from nav.php -->
    <?php include("nav.php"); ?>
    <style>
  
    
    .product-content {
        max-width: 1200px;
        margin: 15px auto;
        background-color: white;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 8px;
        width: 100%; 
        overflow: auto;
    }

    .product-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 6px;
    table-layout: fixed;
    
    
    }


    

    .product-table th, .product-table td {
        border: 1px solid #ddd;
        padding: 1px;
        text-align: center;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        transition: background-color 0.3s; /* Add transition for smooth effect */
        
    }

    .product-table th {
        background-color: #33394a;
        color: #fff;
    }

    .product-table img {
        max-width: 1000px;  
        max-height: 100px; 
    }

   

    .edit-action, .delete-action {
    padding: 5px 10px;
    background-color: #4CAF50;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    }
    .edit-action {
        margin-right: 5px;
    }
    .description-cell {
        max-width: 200px; 
        overflow: hidden;
    }

    .description-content {
        cursor: pointer;
        color: black; 
        white-space: nowrap; 
        overflow: hidden;
        text-overflow: ellipsis;
        display: inline-block;
    }

    .description-content.show-more {
        white-space: normal; 
        overflow: visible;
        text-overflow: initial;
    }
    .product-actions {
    display: flex;
    justify-content: space-evenly; 
    align-items: center; 
}



   

.product-table .product-actions {
    display: flex;
    justify-content: space-around;
    align-items: center;
    width: 100%;
}

.product-table .edit-action {
    padding: 3px 10px;
    background-color: #4CAF50;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    margin: 10px; 
    margin-top: 5px;
}

.product-table .delete-action {
    padding: 3px 10px;
    background-color: #f62727;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    margin: 10px; 
    margin-top: 5px;
}

.close {
  position: absolute;
  top: 2px;
  right: 10px;
  font-size: 20px;
  cursor: pointer;
  color: #aaa;
  float: right;
  font-weight: bold;

}

.delete-btn{
    background-color: red;
}

.delete-actions button {
    width: 100px; 
    margin: 5px;  
}
.searchInput{
    margin-top: 6px;
}

.product-table tr:hover {
    background-color: #f0f0f0; /* Change background color on hover */
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
</head>

<body>
    



        <!-- ================= Product Content ================ -->
        <div class="container">
       <!-- Product Content -->
        <div class="product-content">
            <h2 class="content-header">Inventory List</h2>
            <br>


            <!-- Add Product Button -->
            <button id="addProductBtn" class="add-product-btn">
                <ion-icon name="add-circle-outline"></ion-icon>
                Add Product
            </button>
            
            <!-- Add Stock Button -->
            <!--<button id="addStockBtn" class="add-stock-btn" onclick="openModal('addStockModal')">
            <ion-icon name="add-circle-outline"></ion-icon>
            Add Stock</button>-->

            

 <!-- Search Form -->
 <form id="searchForm">
    <input type="text" id="searchInput" placeholder="Search...">
    <button type="button" onclick="searchTable()"><ion-icon name="search-outline"></ion-icon></button>
</form>

            <!-- Product Table -->
            <table id="product-table" class="product-table"> <!-- Add id="product-table" here -->
    <thead>
        <tr>
            <th>No.</th>
            <th>Product Name</th>
            <th>Image</th>
            <th>Category</th>
            <th>Sale Price</th>
            <th>Stock</th>
            <th>Description</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if ($result && mysqli_num_rows($result) > 0) {
            $count = 1;
            while ($row = mysqli_fetch_assoc($result)) {
                // Output the table row here based on the search results
                echo "<tr>";
                echo "<td>{$count}</td>";
                // Make product name clickable
                echo "<td class='description-cell'><span class='description-content' onclick='toggleDescription(this)'>{$row['pname']}</span></td>";
                echo "<td>";
                if (!empty($row['pimage'])) {
                    echo "<img src='{$row['pimage']}' alt='{$row['pname']}' style='width: 100px; height: 70px;'>";
                }
                echo "</td>";

                echo "<td>{$row['category_name']}</td>";
                echo "<td>{$row['saleprice']}</td>";
                echo "<td>{$row['stock_quantity']}</td>";
                echo "<td class='description-cell'><span class='description-content' onclick='toggleDescription(this)'>{$row['pdescription']}</span></td>";

                // Combine the actions here
               // Update the delete action button
echo "<td class='product-actions-container'>";
echo "<div class='product-actions'>";
echo "<a href='#' class='edit-action' onclick='openEditModal({$row['pid']})'><ion-icon name='create-outline'></ion-icon></a>";
echo "<a href='#' class='delete-action' onclick='deleteProduct({$row['pid']})'><ion-icon name='trash-outline'></ion-icon></a>";
echo "</div>";
echo "</td>";


                echo "</tr>";
                $count++;
            }
        } else {
            echo "<tr><td colspan='8'>No matching products found.</td></tr>";
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
</div>

<!-- JavaScript for delete Functionality -->
<script>
function deleteProduct(productId) {
    var confirmDelete = confirm("Are you sure you want to delete this product?");
    if (confirmDelete) {
        // Send an AJAX request to delete the product
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                // Reload the page after successful deletion
                window.location.reload();
            }
        };

        xhr.open('POST', 'delete_product.php', true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.send('productId=' + productId);
    }
}
</script>


<!-- JavaScript for Search Functionality -->

<script>

    
    function searchTable() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("searchInput");
        filter = input.value.toUpperCase();
        table = document.getElementById("product-table");  // Corrected ID to match your actual table ID
        tr = table.getElementsByTagName("tr");

        // Add console.log statements for debugging
        console.log("input:", input);
        console.log("filter:", filter);
        console.log("table:", table);
        console.log("tr:", tr);

        // Iterate through each row and show/hide based on the search input
        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[1]; // Change index based on the column you want to search

            if (td) {
                txtValue = td.textContent || td.innerText;

                // Check if the row contains the search input
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = ""; // Show the row
                } else {
                    tr[i].style.display = "none"; // Hide the row
                }
            }
        }
    }
</script>



<!--js for modal edit, add-->
<script>





    // Function to open a modal
    function openModal(modalId) {
        var modal = document.getElementById(modalId);
        modal.style.display = 'block';
    }

    // Function to close a modal
    function closeModal(modalId) {
        var modal = document.getElementById(modalId);
        modal.style.display = 'none';
    }

   

    // Function to open the edit modal
    function openEditModal(productId) {
    var editProductModal = document.getElementById('editProductModal');
    editProductModal.style.display = 'block';
    console.log('Edit modal opened for product ID:', productId);
    }

function closeEditModal() {
    console.log('Closing edit modal');
    var editProductModal = document.getElementById('editProductModal');
    editProductModal.style.display = 'none';
}

    // Close modals if the user clicks outside the modal content
    window.onclick = function (event) {
        var modals = document.getElementsByClassName('modal');
        for (var i = 0; i < modals.length; i++) {
            var modal = modals[i];
            if (event.target === modal) {
                modal.style.display = 'none';
            }
        }
    };


    //add//


    
</script>



        <!-- Add Product Modal -->
        <div id="addProductModal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <h2>Add Product</h2>
                
                <!-- Add Product Form -->
                <form action="product.php" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="image">Image:</label>
                        <input type="file" id="image" name="image" accept="image/*" required>
                    </div>
                    <div class="form-group">
                        <label for="itemName">Product Name:</label>
                        <input type="text" id="itemName" name="itemName" required>
                    </div>
                    

                    <div class="form-group">
                    <label for="category">Category:</label>
                    <select id="category" name="category" required>
                        <option value="" disabled selected>Select a category</option>
                        <?php
                        // Fetch categories from the database
                        $categorySql = "SELECT * FROM tbl_category";
                        $categoryResult = mysqli_query($conn, $categorySql);

                        if ($categoryResult && mysqli_num_rows($categoryResult) > 0) {
                            while ($categoryRow = mysqli_fetch_assoc($categoryResult)) {
                                echo "<option value='{$categoryRow['category_id']}'>{$categoryRow['category_name']}</option>";
                            }
                        } else {
                            echo "<option value='' disabled>No categories found</option>";
                        }
                        ?>
                    </select>
                </div>

                    
                    <div class="form-group">
                        <label for="price">Price:</label>
                        <input type="number" id="price" name="price" step="0.01" required>
                    </div>
                    <div class="form-group">
                        <label for="stock">Stock:</label>
                        <input type="number" id="stock" name="stock" required>
                    </div>
                    <div class="form-group">
                        <label for="description">Description:</label>
                        <textarea id="description" name="description" required></textarea>
                    </div>
                    <button type="submit" name="addItem">Add</button>
                </form>
            </div>
        </div>
        
     

        <script>

            
            // JavaScript for modal functionality
            var addProductBtn = document.getElementById("addProductBtn");
            var addProductModal = document.getElementById("addProductModal");
            var closeModal = document.getElementsByClassName("close")[0];

            addProductBtn.onclick = function () {
                addProductModal.style.display = "block";
            };

            closeModal.onclick = function () {
                addProductModal.style.display = "none";
            };

            

            window.onclick = function (event) {
                if (event.target === addProductModal) {
                    addProductModal.style.display = "none";
                }
            };

            //description

           
            function toggleDescription(element) {
            // Toggle between full and truncated description
            if (element.classList.contains('show-more')) {
                element.classList.remove('show-more');
            } else {
                element.classList.add('show-more');
            }
        }

        </script>
    </div>



        <!-- Edit Product Modal -->
    <!-- Edit Product Modal -->
<div id="editProductModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeEditModal()">&times;</span>
        <h2>Edit Product</h2>

        <form id="editProductForm" action="update_product.php" method="POST" enctype="multipart/form-data">
            <!-- You can reuse the same form fields as in the add product modal -->
            <div class="form-group">
                <label for="editImage">Image:</label>
                <input type="file" id="editImage" name="editImage" accept="image/*">
            </div>
            <div class="form-group">
                <label for="editItemName">Product Name:</label>
                <input type="text" id="editItemName" name="editItemName">
            </div>

            <div class="form-group">
                <label for="editCategory">Category:</label>
                <select id="editCategory" name="editCategory" required>
                    <option value="" disabled selected>Select a category</option>
                    <?php
                    // Fetch categories from the database
                    $categorySql = "SELECT * FROM tbl_category";
                    $categoryResult = mysqli_query($conn, $categorySql);

                    if ($categoryResult && mysqli_num_rows($categoryResult) > 0) {
                        while ($categoryRow = mysqli_fetch_assoc($categoryResult)) {
                            echo "<option value='{$categoryRow['category_id']}'>{$categoryRow['category_name']}</option>";
                        }
                    } else {
                        echo "<option value='' disabled>No categories found</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label for="editPrice">Price:</label>
                <input type="number" id="editPrice" name="editPrice" step="0.01">
            </div>

            <div class="form-group">
                <label for="editStock">Stock:</label>
                <input type="number" id="editStock" name="editStock">
            </div>

            <div class="form-group">
                <label for="editDescription">Description:</label>
                <textarea id="editDescription" name="editDescription"></textarea>
            </div>

            <input type="hidden" id="editProductId" name="editProductId">
            <button type="submit" name="editItem">Save Changes</button>
        </form>
    </div>
</div>

<script>
function openEditModal(productId) {
    console.log('Fetching product details for product ID:', productId);

    var editProductModal = document.getElementById('editProductModal');
    editProductModal.style.display = 'block';

    // Fetch product details from the server using AJAX
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4) {
            if (xhr.status == 200) {
                var productDetails = JSON.parse(xhr.responseText);
                console.log('Received product details:', productDetails);

                // Populate the form fields with the retrieved product details
                document.getElementById('editItemName').value = productDetails.pname;
                
                // Use selectedIndex to set the selected option in the dropdown
                document.getElementById('editCategory').selectedIndex = productDetails.pcategory;
                
                document.getElementById('editPrice').value = productDetails.saleprice;
                document.getElementById('editStock').value = productDetails.stock_quantity;
                document.getElementById('editDescription').value = productDetails.pdescription;
                document.getElementById('editProductId').value = productId;
            } else {
                console.error('Error fetching product details. Status:', xhr.status);
            }
        }
    };

    // Send an AJAX request to fetch product details
    xhr.open('GET', `get_product_details.php?productName=${productId}`, true);
    xhr.send();

    
}


</script>










    <!-- =========== Scripts =========  -->
    <script src="assets/js/main.js"></script>

    <!-- ======= Charts JS ====== -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.1/dist/chart.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <script src="assets/js/chartsJS.js"></script>

    <!-- ====== ionicons ======= -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>

</html>