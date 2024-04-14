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
    <title>Cashier</title>
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



/* Notification Styles */
.notification-container {
    position: fixed;
    top: 20px;
    right: 20px;
    z-index: 1000;
}

.alert {
    position: relative;
    padding: 1rem 1.25rem;
    margin-bottom: 1rem;
    border: 1px solid transparent;
    border-radius: 0.25rem;
}

.alert-success {
    color: #155724;
    background-color: #d4edda;
    border-color: #c3e6cb;
}

.alert-danger {
    color: #721c24;
    background-color: #f8d7da;
    border-color: #f5c6cb;
}

    </style>

<body>
   

            <!-- ======================= Cards ================== -->
            <div class="cardBox">

          
            <div class="card">
                <div>
                    <div class="numbers"><?php echo $totalProductsCount; ?></div>
                    <div class="cardName">Total Products</div>
                </div>
                <div class="iconBx">
                    <ion-icon name="pricetags-outline"></ion-icon>
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
                 <div class="chartsBx">
                <div class="chart"> <canvas id="chart-1"></canvas> </div>
                <div class="chart"> <canvas id="chart-2"></canvas> </div>
            </div>
            
            <script>
                // Define the function to fetch actual data for the charts
function fetchChartData() {
    fetch('fetch_chart_data.php') // Adjust the URL according to your backend endpoint
        .then(response => response.json())
        .then(data => {
            const totalProducts = data.totalProducts;
            const totalSales = data.totalSales;
            const totalOrders = data.totalOrders;

            // Update chart datasets
            polarAreaChart.data.datasets[0].data = [totalProducts, totalSales, totalOrders];
            barChart.data.datasets[0].data = [totalProducts, totalSales, totalOrders];

            // Update charts
            polarAreaChart.update();
            barChart.update();
        })
        .catch(error => {
            console.error('Error fetching chart data:', error);
        });
}

// Call fetchChartData function after chart configurations
fetchChartData();
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