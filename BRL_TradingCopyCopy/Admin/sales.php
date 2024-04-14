<?php
include '../connections.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if the request is an AJAX request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['fromDate']) && isset($_POST['toDate'])) {
    // Sanitize input
    $fromDate = mysqli_real_escape_string($conn, $_POST['fromDate']);
    $toDate = mysqli_real_escape_string($conn, $_POST['toDate']);

    // Query to fetch sales data based on the selected date range
    $query = "SELECT product_name, order_date, quantity, price FROM tbl_orders WHERE order_date BETWEEN '$fromDate' AND '$toDate'";
    $result = mysqli_query($conn, $query);

    // Check if the query was successful
    if ($result) {
        $salesData = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $salesData[] = $row;
        }
        // Encode the sales data as JSON and send it back to the client
        echo json_encode($salesData);
        exit;
    } else {
        // Handle query error
        echo "Error fetching sales data: " . mysqli_error($conn);
        exit;
    }
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
    <link rel="stylesheet" href="./assets/css/style.css">
    <!-- Include the styles and scripts from nav.php -->
    <?php include("nav.php"); ?>
</head>
<style>
    .sales-container {
        margin-top: 20px;
        padding: 20px;
        border: 1px solid #ccc;
        border-radius: 5px;
        background-color: white;
        width: 100%; /* Adjust width as needed */
        max-width: 1100px; /* Adjust maximum width as needed */
        margin: 0 auto; /* Center the container horizontally */
    }

    .sales-container h2 {
        margin-bottom: 10px;
        font-size: 20px;
        font-weight: bold; /* Make the heading bold */
        text-align: center; /* Center align the heading */
    }

    .form-group1 {
        margin-bottom: 15px;
        display: flex; /* Add flex display */
        align-items: center; /* Align items vertically */
        justify-content: center; /* Center items horizontally */
        flex-wrap: wrap; /* Allow wrapping if needed */
    }

    .form-group1 label {
        margin-right: 10px; /* Add spacing between label and input */
        font-weight: bold;
    }

    .form-group1 input[type="date"] {
        width: 200px; /* Set width of date inputs */
        padding: 5px;
        font-size: 16px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    .form-group1 button {
        padding: 8px 15px;
        font-size: 16px;
        background-color: #007bff;
        color: #fff;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    .form-group button:hover {
        background-color: #0056b3;
    }

    #totalSales {
        margin-top: 15px;
        font-size: 18px;
        font-weight: bold;
        text-align: center;
        background-color: #f2f2f2;
        padding: 10px;
        border-radius: 5px;
    }

    #salesTable {
        width: 100%;
        border-collapse: collapse;
    }

    #salesTable th,
    #salesTable td {
        padding: 10px;
        border-bottom: 1px solid #ddd;
        text-align: left;
    }

    #salesTable th {
        background-color: #33394a;
        color: white;
    }

    #salesTable tbody tr:hover {
        background-color: #f5f5f5;
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
    


    <!-- =============== Sales Container ================ -->
    <!-- Sales Container -->
<div class="sales-container">
    <h2>TOTAL SALES</h2>

    <!-- Date Range Dropdowns -->
    <div class="form-group1">
        <label for="fromDate">From:</label>
        <input type="date" id="fromDate" name="fromDate">
        <label for="toDate">To:</label>
        <input type="date" id="toDate" name="toDate">
    </div>

    <!-- Get Sales Button -->
    <div class="form-group1">
        <button id="getSalesBtn" onclick="fetchSales()">Get Sales</button>
    </div>

    <!-- Placeholder for displaying total sales -->
    <div id="totalSales"></div>

    <!-- Placeholder for displaying sales data (to be updated dynamically) -->
    <!--<div id="salesData"></div>-->

    <!-- Sales Table -->
    <div class="sales-container">
        <h2>SALES DATA</h2>
        <div id="totalSales"></div> <!-- Display total sales here -->

        <table id="salesTable">
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Order Date</th>
                    <th>Quantity</th>
                    <th>Sales</th>
                </tr>
            </thead>
            <tbody>
            
            </tbody>
        </table>
    </div>
</div>
<script>
    function fetchSales() {
        // Get the selected date range
        const fromDate = document.getElementById('fromDate').value;
        const toDate = document.getElementById('toDate').value;

        // Send an AJAX request to fetch sales data
        const xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function () {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    // Parse the JSON response
                    const salesData = JSON.parse(xhr.responseText);
                    // Update the sales table with the fetched data
                    updateSalesTable(salesData);
                    // Calculate and display total sales
                    displayTotalSales(salesData);
                } else {
                    console.error('Error fetching sales data:', xhr.statusText);
                }
            }
        };

        // Specify the PHP script that handles the AJAX request
        xhr.open('POST', 'fetch_sales.php', true);
        // Set the request headers
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        // Send the request with the selected date range
        xhr.send(`fromDate=${fromDate}&toDate=${toDate}`);
    }

    // Function to update the sales table dynamically
    function updateSalesTable(salesData) {
        const salesTableBody = document.querySelector('#salesTable tbody');
        // Clear existing table rows
        salesTableBody.innerHTML = '';

        // Populate the table with the fetched sales data
        salesData.forEach((sale) => {
            const row = salesTableBody.insertRow();
            row.insertCell(0).textContent = sale.product_name;
            row.insertCell(1).textContent = sale.order_date;
            row.insertCell(2).textContent = sale.quantity;
            row.insertCell(3).textContent = sale.price;
        });
    }

    // Function to calculate and display total sales
    function displayTotalSales(salesData) {
        const totalSalesElement = document.getElementById('totalSales');
        // Calculate the total sales from the fetched data
        const totalSales = salesData.reduce((total, sale) => total + parseFloat(sale.price), 0);
        // Display the total sales at the top of the table
        totalSalesElement.innerHTML = `<p>TOTAL SALES FROM ${document.getElementById('fromDate').value} TO ${document.getElementById('toDate').value} : ${totalSales.toFixed(2)}</p>`;
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