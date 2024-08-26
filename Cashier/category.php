<?php
// Include the database connection
include '../connections.php';

// Include the HTML header
include 'header.php';
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
</head>

<style>


    .category-content {
        max-width: 1150px;
        margin: 20px auto;
        padding: 60px;
        border: 1px solid #ccc;
        border-radius: 8px;
        background-color: white;
    }

    .category-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
        background-color: #fff;
    }

    .category-table th, .category-table td {
        border: 1px solid #ddd;
        padding: 10px;
        text-align: center;
    }

    .category-table th {
        background-color: #33394a;
        color: #fff;
    }

    .category-actions {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .delete-action {
        padding: 8px;
        background-color: #e74c3c;
        color: #fff;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .delete-action:hover {
        background-color: #c0392b;
    }

  
    #addCategoryModal {
        display: none;
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background-color: transparent;
        padding: 10px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
    }

    #addCategoryModal h2 {
        margin-bottom: 20px;
    }

   

    #addCategoryForm button {
        background-color: #4CAF50;
        color: #fff;
        padding: 10px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    

    .close {
        position: absolute;
        top: 5px;
        right: 5px;
        font-size: 20px;
        cursor: pointer;
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
    
            <!-- ================= Category ================ -->


            <!-- Category Content -->
<!-- Category Content -->
<div class="category-content">
        <h2 class="content-header">Category</h2><br>

        <!-- Add Category Button -->
        <button id="addCategoryBtn" class="add-category-btn" onclick="openModal('addCategoryModal')">
            <ion-icon name="add-circle-outline"></ion-icon>Add Category
        </button>

        <!-- Category Table -->
        <table class="category-table" id="categoryTable">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Category Name</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Fetch categories from the database and populate the table rows
                $categorySql = "SELECT * FROM tbl_category";
                $categoryResult = mysqli_query($conn, $categorySql);

                if ($categoryResult) {
                    $categoryCount = 1;
                    $stmt = $conn->prepare("SELECT category_id, category_name FROM tbl_category");
                    $stmt->execute();
                    $stmt->bind_result($categoryId, $categoryName);

                    while ($stmt->fetch()) {
                        echo "<tr>";
                        echo "<td>{$categoryCount}</td>";
                        echo "<td>{$categoryName}</td>";
                        echo "<td class='category-actions'>";
                        echo "<a href='#' class='delete-action' data-category-id='{$categoryId}' onclick='deleteCategory(this)'><ion-icon name='trash-outline'></ion-icon></a>";
                        echo "</td>";
                        echo "</tr>";
                        $categoryCount++;
                    }
                    $stmt->close();
                } else {
                    echo "<tr><td colspan='3'>No categories found.</td></tr>";
                }
                ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3">
                        <button id="prevPageBtn" disabled>Previous</button>
                        <button id="nextPageBtn" disabled>Next</button>
                    </td>
                </tr>
            </tfoot>
        </table>

        <script>
            document.addEventListener("DOMContentLoaded", function () {
                var table = document.querySelector("#categoryTable");
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
    </div>
<!-- Add Category Modal -->
<div id="addCategoryModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal('addCategoryModal')">&times;</span>
        <h2>Add Category</h2>

        <!-- Add Category Form -->
        <form id="addCategoryForm" action="add_category.php" method="POST">
            <div class="form-group">
                <label for="categoryName">Category Name:</label>
                <input type="text" id="categoryName" name="categoryName" placeholder="Enter category name" required>
            </div>
            <button type="submit" name="addCategory" onclick="addCategory()">Add Category</button>
        </form>
    </div>
</div>
<script>
    // Function to delete a category
    function deleteCategory(element) {
        var confirmation = confirm('Are you sure you want to delete this category?');

        if (confirmation) {
            // Access the data-category-id attribute
            var categoryId = element.getAttribute('data-category-id');

            // Use fetch to send a DELETE request to the server
            fetch('delete_category.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'categoryId=' + encodeURIComponent(categoryId),
            })
                .then(response => response.json())
                .then(data => {
                    // Handle the response from the server
                    if (data.success) {
                        alert("Category deleted successfully!");
                        // Optionally, you can remove the deleted row from the table
                        element.closest('tr').remove();
                    } else {
                        alert("Failed to delete category. " + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert("An error occurred while trying to delete the category.");
                });
        }
    }
</script>


   






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