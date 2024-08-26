<?php
// Include your database connection file
include("../connections.php");

// Fetch data from your database
$totalProductsQuery = "SELECT COUNT(*) as totalProducts FROM tbl_product";
$totalProductsResult = mysqli_query($conn, $totalProductsQuery);
$totalProductsData = mysqli_fetch_assoc($totalProductsResult);
$totalProductsCount = $totalProductsData['totalProducts'];

$totalSalesQuery = "SELECT COUNT(*) as totalSales FROM tbl_orders";
$totalSalesResult = mysqli_query($conn, $totalSalesQuery);
$totalSalesData = mysqli_fetch_assoc($totalSalesResult);
$totalSalesCount = $totalSalesData['totalSales'];

$totalOrdersQuery = "SELECT COUNT(*) as totalOrders FROM tbl_orders";
$totalOrdersResult = mysqli_query($conn, $totalOrdersQuery);
$totalOrdersData = mysqli_fetch_assoc($totalOrdersResult);
$totalOrdersCount = $totalOrdersData['totalOrders'];

// Format the data as an associative array
$data = array(
    "totalProducts" => $totalProductsCount,
    "totalSales" => $totalSalesCount,
    "totalOrders" => $totalOrdersCount
);

// Set the appropriate headers to indicate JSON content
header('Content-Type: application/json');

// Return the data as JSON
echo json_encode($data);
?>
