<?php include("../connections.php");



//for product cardbox//
// Fetch the total count of products
$totalProductsQuery = "SELECT COUNT(*) as totalProducts FROM tbl_product";
$totalProductsResult = mysqli_query($conn, $totalProductsQuery);

// Check if the query was successful
if ($totalProductsResult) {
    $totalProductsData = mysqli_fetch_assoc($totalProductsResult);
    $totalProductsCount = $totalProductsData['totalProducts'];
} else {
    // Handle the error, for example:
    $totalProductsCount = 'N/A';
}


//for orders cardbox//
// Fetch total orders count
$totalOrdersResponse = file_get_contents('get_total_orders.php');

// Parse JSON response
$totalOrdersData = json_decode($totalOrdersResponse, true);

// Check if JSON decoding was successful
if ($totalOrdersData !== null && isset($totalOrdersData['totalOrders'])) {
    // Extract total orders from the response
    $totalOrders = $totalOrdersData['totalOrders'];
} else {
    // Set default value or handle error
    $totalOrders = 0;
}
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
    <!-- Include the styles and scripts from nav.php -->
    <?php include("nav.php"); ?>
</head>
<style>
/* Table Styles */
table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 0px;
            margin-bottom: 250px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
            margin-top: 10px;
            
        }

        th {
            background-color: #33394a;
            color: white;
            align-items: center;
        }

        /* Button Style */
        .btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 10px;
        }

        /* Optional: Hover effect for the button */
        .btn:hover {
            background-color: #45a049;
        }

        .cardHeader {
        display: flex;
        justify-content: space-between;
        align-items: center;
        
    }

    .cardHeader h2 {
        font-size: 1.5rem;
        margin-top: 10px;
        
    }

    .btn {
        display: inline-block;
        padding: 10px 20px;
        background-color: #4CAF50;
        color: #fff;
        text-decoration: none;
        border-radius: 5px;
        margin-top: 10px;
    }

    .btn:hover {
        background-color: #45a049;
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
  


            <!-- ======================= Cards ================== -->
            <div class="cardBox">

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
                    <div class="numbers"><?php echo $totalProductsCount; ?></div>
                    <div class="cardName">Total Products</div>
                </div>
                <div class="iconBx">
                    <ion-icon name="pricetags-outline"></ion-icon>
                </div>
            </div>

            
            <div class="card">
                <div>
                    <div class="numbers" id="dashboardSalesCount">Loading...</div>
                    <div class="cardName">Total Sales</div>
                </div>

                <div class="iconBx">
                    <ion-icon name="cart-outline"></ion-icon>
                </div>
            </div>

                <script>
            // Function to fetch sales count for the dashboard
            function fetchDashboardSalesCount() {
                // Send an AJAX request to fetch sales count
                const xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function () {
                    if (xhr.readyState === XMLHttpRequest.DONE) {
                        if (xhr.status === 200) {
                            // Parse the JSON response
                            const salesCount = JSON.parse(xhr.responseText);
                            // Update the sales count display on the dashboard
                            updateDashboardSalesCount(salesCount);
                        } else {
                            console.error('Error fetching sales count:', xhr.statusText);
                        }
                    }
                };

                // Specify the PHP script that handles the AJAX request for sales count
                xhr.open('GET', 'fetch_dashboard_sales.php', true);
                // Send the request
                xhr.send();
            }

            // Function to update the sales count display on the dashboard
            function updateDashboardSalesCount(salesCount) {
                const dashboardSalesCount = document.getElementById('dashboardSalesCount');
                // Update the content of the element with the fetched sales count
                dashboardSalesCount.innerHTML = salesCount;
            }

            // Fetch sales count when the dashboard loads
            window.onload = function () {
                fetchDashboardSalesCount();
            };
            </script>

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
                        <div class="numbers" id="totalOrdersCount"><?php echo $totalOrders; ?></div>
                        <div class="cardName">Total Orders</div>
                    </div>
                    <div class="iconBx">
                        <ion-icon name="cart-outline"></ion-icon>
                    </div>
                </div>
                <script>
                    document.addEventListener("DOMContentLoaded", function () {
                        // Fetch total orders count
                        var totalOrdersResponse = fetch('get_total_orders.php')
                            .then(response => response.json())
                            .then(data => {
                                // Extract total orders from the response
                                var totalOrders = data.totalOrders;

                                // Update the Total Orders card with the fetched value
                                document.getElementById('totalOrdersCount').innerText = totalOrders;
                            })
                            .catch(error => {
                                console.error('Error fetching total orders:', error);
                            });
                    });
                </script>

            </div>

           <!-- ================ Add Charts JS ================= -->
                 <!--<div class="chartsBx">
                <div class="chart"> <canvas id="chart-1"></canvas> </div>
                <div class="chart"> <canvas id="chart-2"></canvas> </div>
            </div>-->

            <!-- ================ Order Details List ================= -->
            <div class="details">
                <!-- Recent Orders -->
    <div class="recentOrders">
        <div class="cardHeader">
            <h2>Recent Orders</h2>
            <a href="purchase.php" class="btn">View All</a>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Order Date</th>
                    <th>Quantity</th>
                    <th>Paid</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Fetch recent orders from the orderlist table
                $recentOrdersQuery = "SELECT * FROM tbl_orders ORDER BY order_date DESC LIMIT 5";
                $recentOrdersResult = mysqli_query($conn, $recentOrdersQuery);

                if ($recentOrdersResult && mysqli_num_rows($recentOrdersResult) > 0) {
                    while ($orderData = mysqli_fetch_assoc($recentOrdersResult)) {
                        echo "<tr>";
                        echo "<td>{$orderData['product_name']}</td>";
                        echo "<td>{$orderData['order_date']}</td>";
                        echo "<td>{$orderData['quantity']}</td>";
                        echo "<td>{$orderData['price']}</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>No recent orders</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

                <!-- ================= New user ================ -->
<div class="recentCustomers">
    <div class="cardHeader">
        <h2>Recent Users</h2>
    </div>

    <table>
        <thead>
            <tr>
                <th>User ID</th>
                <th>Username</th>
                <th>Email</th>
                <!-- Add more columns as needed -->
            </tr>
        </thead>
        <tbody id="recentUsersTableBody">
            <!-- Recent user data will be dynamically added here using JavaScript -->
        </tbody>
    </table>
</div>
<script>
// Update the document.addEventListener block in the <script> section of your dashboard.php file

document.addEventListener("DOMContentLoaded", function () {
    // Function to fetch recent user data
    function fetchRecentUsers() {
        fetch('get_recent_users.php')
            .then(response => response.json())
            .then(data => {
                renderRecentUsers(data);
            })
            .catch(error => {
                console.error('Error fetching recent users:', error);
            });
    }

    // Function to render recent user data in the table
    function renderRecentUsers(users) {
        const recentUsersTableBody = document.getElementById("recentUsersTableBody");
        recentUsersTableBody.innerHTML = "";

        users.forEach(user => {
            const row = createRecentUserRow(user);
            recentUsersTableBody.appendChild(row);
        });
    }

    // Function to create a row for a recent user
    function createRecentUserRow(user) {
        const row = document.createElement("tr");
        row.innerHTML = `
            <td>${user.user_id}</td>
            <td>${user.username}</td>
            <td>${user.useremail}</td>
            <!-- Add more columns as needed -->
        `;
        return row;
    }

    // Fetch recent user data when the dashboard loads
    fetchRecentUsers();
});
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