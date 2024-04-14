<?php
// Include your database connection file
include("../connections.php");

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <!-- ======= Styles ====== -->
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
    <!-- =============== Navigation ================ -->
    <div class="container">
        <div class="navigation">
            <ul>
                <li>
                    <a href="#">
                        <span class="icon">
                            <img src="ASSETS/imgs/logo_brl.png" width="100px" height="60px" alt="logo" />
                        </span>
                        <span class="title"></span>
                    </a>
                </li>

                <li>
                    <a href="dashboard.php">
                        <span class="icon">
                            <ion-icon name="home-outline"></ion-icon>
                        </span>
                        <span class="title">Dashboard</span>
                    </a>
                </li>

                <li>
                    <a href="product.php">
                        <span class="icon">
                        <ion-icon name="folder-open-outline"></ion-icon>
                        </span>
                        <span class="title">Inventory List</span>
                    </a>
                </li>

                <li>
                    <a href="category.php">
                        <span class="icon">
                        <ion-icon name="options-outline"></ion-icon>
                        </span>
                        <span class="title">Category</span>
                    </a>
                </li>

                <li>
                    <a href="stock.php">
                        <span class="icon">
                        <ion-icon name="pricetags-outline"></ion-icon>
                        </span>
                        <span class="title">Stock</span>
                    </a>
                </li>

                <li>
                    <a href="purchase.php">
                        <span class="icon">
                            <ion-icon name="list-outline"></ion-icon>
                        </span>
                        <span class="title">Purchase Order List</span>
                    </a>
                </li>

                <li>
                    <a href="sales.php">
                        <span class="icon">
                        <ion-icon name="analytics-outline"></ion-icon>
                        </span>
                        <span class="title">Sales</span>
                    </a>
                </li>

                <li>
                    <a href="reports.php">
                        <span class="icon">
                        <ion-icon name="document-text-outline"></ion-icon>
                        </span>
                        <span class="title">Reports</span>
                    </a>
                </li>

                
         

                <li>
                    <a href="logout.php">
                        <span class="icon">
                            <ion-icon name="log-out-outline"></ion-icon>
                        </span>
                        <span class="title">Sign Out</span>
                    </a>
                </li>
            </ul>
        </div>

        <!-- ========================= Main ==================== -->
        <div class="main">
            <div class="topbar">
                <div class="toggle">
                    <ion-icon name="menu-outline"></ion-icon>

                 
                </div>

                
                <div class="title" onclick="alert('Title Clicked!')">
                    <ion-icon name="basket-outline"></ion-icon>
                    <h4>POS with Inventory</h4>
                </div>


                <div class="user-dropdown">
                <div class="user">
                    <img src="assets/imgs/customer01.png" alt="">
                </div>
                <div class="dropdown-content">
                    <a href="#" onclick="openModal('profileModal')">Profile</a>
                    <a href="#" onclick="openModal('logoutModal')" class="logout">Logout</a>
                </div>
            </div>

            </div>
<!-- Profile Modal -->
<div id="profileModal" class="modal">
    <div class="modal-content small">
        <span class="close" onclick="closeModal('profileModal')">&times;</span>
        <h2>Profile</h2>
        <h3>Hi, Cashier!</h3>

        <!-- Profile Information -->
        <div class="profile-info">
      
            
        </div>
    </div>
</div>


<!-- JavaScript code -->
<script>
    // Function to open the modal
    function openModal(modalId) {
        var modal = document.getElementById(modalId);
        if (modal) {
            modal.style.display = 'block';
        }
    }

    // Function to close the modal
    function closeModal(modalId) {
        var modal = document.getElementById(modalId);
        if (modal) {
            modal.style.display = "none";
        }
    }

    // Function to handle logout
    function confirmLogout() {
        // Submit the logout form
        document.getElementById("logoutForm").submit();
    }

    // Event listener for the logout form submission
    document.getElementById("logoutForm").addEventListener("submit", function (event) {
        // Prevent the default form submission
        event.preventDefault();
        // Call the confirmLogout function
        confirmLogout();
    });
</script>




           
<!-- Logout Modal -->
<div id="logoutModal" class="modal">
    <div class="modal-content small">
        <span class="close" onclick="closeModal('logoutModal')">&times;</span>
        <h2 class="modal-title">Logout</h2>
        <p class="modal-message">Are you sure you want to log out?</p>
        <div class="logout-actions">
            <!-- Call the confirmLogout function when the "Logout" button is clicked -->
            <button class="logout-btn" onclick="confirmLogout()">Logout</button>
            <!-- Simply close the modal when the "Cancel" button is clicked -->
            <button class="cancel-btn" onclick="closeModal('logoutModal')">Cancel</button>
        </div>
    </div>
</div>

<script>
    // Function to open the modal
    function openModal() {
        document.getElementById('logoutModal').style.display = 'block';
    }

    // Function to close the modal
    function closeModal(modalId) {
        var modal = document.getElementById(modalId);
        modal.style.display = "none";
    }

    // Function to handle logout
    function confirmLogout() {
        // Submit the logout form
        document.getElementById("logoutForm").submit();
    }

    // Event listener for the logout form submission
    document.getElementById("logoutForm").addEventListener("submit", function(event) {
        // Prevent the default form submission
        event.preventDefault();
        // Call the confirmLogout function
        confirmLogout();
    });
</script>

<form id="logoutForm" method="post" action="logout.php">
    <!-- Your form content here -->
    <input type="hidden" name="logout" value="1">
</form>

