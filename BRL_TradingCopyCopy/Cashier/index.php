<?php include("../connections.php");
/*header('location:../LOGIN/login.php');*/
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cashier</title>
    <!-- ======= Styles ====== -->
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
    <!-- =============== Navigation ================ -->
   <!-- <div class="container">-->
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

                

               

                <!---
                <li>
                    <a href="#">
                        <span class="icon">
                            <ion-icon name="settings-outline"></ion-icon>
                        </span>
                        <span class="title">POS</span>
                    </a>
                </li>

                <li>
                    <a href="#">
                        <span class="icon">
                            <ion-icon name="lock-closed-outline"></ion-icon>
                        </span>
                        <span class="title">Inventory</span>
                    </a>
                </li>-->

                

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
                    <a href="#" onclick="openModal('settingsModal')">Settings</a>
                    <a href="#" onclick="openModal('logoutModal')" class="logout">Logout</a>
                </div>
            </div>

            </div>

                        <!-- Profile Modal -->
                            <div id="profileModal" class="modal">
                                <div class="modal-content">
                                    <span class="close" onclick="closeModal('profileModal')">&times;</span>
                                    <h2>Profile</h2>

                                    <!-- Profile Information -->
                                    <div class="profile-info">
                                        <?php
                                        // Start the session
                                        session_start();

                                        // Check if the user is logged in
                                        if (isset($_SESSION['user_id'])) {
                                            // Include your database connection file
                                            include '../connections.php';

                                            // Fetch user details from the database
                                            $userId = $_SESSION['user_id'];
                                            $query = "SELECT username, email, user_type FROM users WHERE id = $userId";
                                            $result = mysqli_query($conn, $query);

                                            if ($result && mysqli_num_rows($result) > 0) {
                                                $userData = mysqli_fetch_assoc($result);
                                                $greetingType = ucfirst($userData['user_type']); // Capitalize the user type
                                                echo "<p>Hello, {$greetingType} {$userData['username']}!</p>";
                                                echo "<p>Email: {$userData['email']}</p>";
                                            } else {
                                                echo "<p>Error fetching user information.</p>";
                                            }
                                        } else {
                                            echo "<p>User not logged in.</p>";
                                        }
                                        ?>
                                    </div>
                            <!-- Edit Account Form -->
                            <form id="editAccountForm" action="edit_account.php" method="POST">
                                <div class="form-group">
                                    <label for="editUsername">New Username:</label>
                                    <input type="text" id="editUsername" name="editUsername" placeholder="Enter new username">
                                </div>
                                <div class="form-group">
                                    <label for="editPassword">New Password:</label>
                                    <input type="password" id="editPassword" name="editPassword" placeholder="Enter new password">
                                </div>
                                <!-- Add more fields as needed for editing account details -->

                                <button type="submit" name="editAccount">Save Changes</button>
                            </form>
                        </div>
                    </div>



            <!-- Settings Modal -->
<div id="settingsModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal('settingsModal')">&times;</span>
        <h2>Settings</h2>

        <!-- General Settings -->
        <div class="settings-section">
            <h3>General Settings</h3>
            <form id="generalSettingsForm" action="update_settings.php" method="POST">
                <div class="form-group">
                    <label for="siteName">Site Name:</label>
                    <input type="text" id="siteName" name="siteName" placeholder="Enter site name">
                </div>
                <!-- Add more general settings as needed -->
                <button type="submit" name="updateGeneralSettings">Save Changes</button>
            </form>
        </div>

        <!-- Security Settings -->
        <div class="settings-section">
            <h3>Security Settings</h3>
            <form id="securitySettingsForm" action="update_settings.php" method="POST">
                <div class="form-group">
                    <label for="changePassword">Change Password:</label>
                    <input type="password" id="changePassword" name="changePassword" placeholder="Enter new password">
                </div>
                <!-- Add more security settings as needed -->
                <button type="submit" name="updateSecuritySettings">Save Changes</button>
            </form>
        </div>

        <!-- Other Settings Sections -->
        <!-- Add more sections and settings forms as needed -->

    </div>
</div>


<!-- Logout Modal -->
<div id="logoutModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal('logoutModal')">&times;</span>
        <h2 class="modal-title">Logout</h2>
        <p class="modal-message">Are you sure you want to log out?</p>
        <div class="logout-actions">
            <!-- Call the logout function when the "Logout" button is clicked -->
            <button class="logout-btn" onclick="logout()">Logout</button>
            <!-- Simply close the modal when the "Cancel" button is clicked -->
            <button class="cancel-btn" onclick="closeModal('logoutModal')">Cancel</button>
        </div>
    </div>
</div>

<script>
    // JavaScript function to logout
    function logout() {
        // You can add any additional logout logic here, such as redirecting to a logout script
        // Redirect to the login page after successful logout
        window.location.href = '../LOGIN/login.php';
    }

    // Function to close the modal
    function closeModal(modalId) {
        var modal = document.getElementById(modalId);
        modal.style.display = "none";
    }
</script>











       

















            <!-- ======================= Cards ================== -->
            <div class="cardBox">
                <div class="card">
                    <div>
                        <div class="numbers">1,504</div>
                        <div class="cardName">Product in Stock</div>
                    </div>

                    <div class="iconBx">
                        <ion-icon name="pricetags-outline"></ion-icon>
                    </div>
                </div>

                <div class="card">
                    <div>
                        <div class="numbers">80</div>
                        <div class="cardName">Sales</div>
                    </div>

                    <div class="iconBx">
                        <ion-icon name="cart-outline"></ion-icon>
                    </div>
                </div>

                <!--<div class="card">
                    <div>
                        <div class="numbers">284</div>
                        <div class="cardName">Comments</div>
                    </div>

                    <div class="iconBx">
                        <ion-icon name="chatbubbles-outline"></ion-icon>
                    </div>
                </div>-->

                <div class="card">
                    <div>
                        <div class="numbers">42</div>
                        <div class="cardName">New Orders</div>
                    </div>

                    <div class="iconBx">
                        <ion-icon name="cart-outline"></ion-icon>
                    </div>
                </div>
            </div>

           <!-- ================ Add Charts JS ================= -->
                 <!--<div class="chartsBx">
                <div class="chart"> <canvas id="chart-1"></canvas> </div>
                <div class="chart"> <canvas id="chart-2"></canvas> </div>
            </div>-->

            <!-- ================ Order Details List ================= -->
            <div class="details">
                <div class="recentOrders">
                    <div class="cardHeader">
                        <h2>Recent Orders</h2>
                        <a href="#" class="btn">View All</a>
                    </div>

                    <table>
                        <thead>
                            <tr>
                                <td>Name</td>
                                <td>Price</td>
                                <td>Payment</td>
                                <td>Status</td>
                            </tr>
                        </thead>

                        <tbody>
                            <tr>
                                <td>Tissue</td>
                                <td>$1200</td>
                                <td>Paid</td>
                                <td><span class="status delivered">Delivered</span></td>
                            </tr>

                            <tr>
                                <td>Dishwashing</td>
                                <td>$110</td>
                                <td>Due</td>
                                <td><span class="status pending">Pending</span></td>
                            </tr>

                            <tr>
                                <td>Vacuum</td>
                                <td>$1200</td>
                                <td>Paid</td>
                                <td><span class="status return">Return</span></td>
                            </tr>

                            <tr>
                                <td>Trash Bag</td>
                                <td>$620</td>
                                <td>Due</td>
                                <td><span class="status inProgress">In Progress</span></td>
                            </tr>

                            <tr>
                                <td>Mop</td>
                                <td>$1200</td>
                                <td>Paid</td>
                                <td><span class="status delivered">Delivered</span></td>
                            </tr>

                            <tr>
                                <td>Soap</td>
                                <td>$110</td>
                                <td>Due</td>
                                <td><span class="status pending">Pending</span></td>
                            </tr>

                            
                        </tbody>
                    </table>
                </div>

                <!-- ================= New Customers ================ -->
                <div class="recentCustomers">
                    <div class="cardHeader">
                        <h2>Recent User</h2>
                    </div>

                    <table>
                        <tr>
                            <td width="60px">
                                <div class="imgBx"><img src="assets/imgs/customer01.png" alt=""></div>
                            </td>
                            <td>
                                <h4>User1 <br> <span>Italy</span></h4>
                            </td>
                        </tr>

                        <tr>
                            <td width="60px">
                                <div class="imgBx"><img src="assets/imgs/customer01.png" alt=""></div>
                            </td>
                            <td>
                                <h4>User2 <br> <span>India</span></h4>
                            </td>
                        </tr>

                        <tr>
                            <td width="60px">
                                <div class="imgBx"><img src="assets/imgs/customer01.png" alt=""></div>
                            </td>
                            <td>
                                <h4>User3 <br> <span>Italy</span></h4>
                            </td>
                        </tr>

                        <tr>
                            <td width="60px">
                                <div class="imgBx"><img src="assets/imgs/customer01.png" alt=""></div>
                            </td>
                            <td>
                                <h4>User4 <br> <span>India</span></h4>
                            </td>
                        </tr>

                        <tr>
                            <td width="60px">
                                <div class="imgBx"><img src="assets/imgs/customer01.png" alt=""></div>
                            </td>
                            <td>
                                <h4>User5 <br> <span>Italy</span></h4>
                            </td>
                        </tr>

                        
                    </table>
                </div>
            </div>
        </div>
    </div>

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