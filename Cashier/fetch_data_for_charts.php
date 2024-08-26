<?php
include("../connections.php");

// Fetch data for the charts
$totalProductsQuery = "SELECT COUNT(*) as totalProducts FROM tbl_product";
$totalProductsResult = mysqli_query($conn, $totalProductsQuery);
$totalProductsData = mysqli_fetch_assoc($totalProductsResult);
$totalProductsCount = $totalProductsData['totalProducts'];

// Fetch total sales from get_total_sales.php
$totalSalesResponse = file_get_contents('get_total_sales.php');
$totalSalesData = json_decode($totalSalesResponse, true);
$totalSales = $totalSalesData['totalSales'];

// Fetch total orders from get_total_orders.php
$totalOrdersResponse = file_get_contents('get_total_orders.php');
$totalOrdersData = json_decode($totalOrdersResponse, true);
$totalOrders = $totalOrdersData['totalOrders'];

// Prepare data for JSON response
$response = array(
    'totalProducts' => $totalProductsCount,
    'totalSales' => $totalSales,
    'totalOrders' => $totalOrders
);

// Return JSON response
header('Content-Type: application/json');
echo json_encode($response);
?>
