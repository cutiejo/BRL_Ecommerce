<?php
// Include the database connection
include '../connections.php';

// Number of products per page
$productsPerPage = 10;

// Get the selected page from the request
$page = isset($_GET['page']) ? $_GET['page'] : 1;

// Calculate the starting point for fetching products
$start = ($page - 1) * $productsPerPage;

// Fetch products for the current page
$sql = "SELECT * FROM tbl_product LIMIT $start, $productsPerPage";
$result = mysqli_query($conn, $sql);

// Build the table body
$tableBody = "";
$count = $start + 1;

while ($row = mysqli_fetch_assoc($result)) {
    $tableBody .= "<tr>";
    $tableBody .= "<td>{$count}</td>";
    $tableBody .= "<td>{$row['pname']}</td>";
    $tableBody .= "<td>";
    if (!empty($row['pimage'])) {
        $tableBody .= "<img src='{$row['pimage']}' alt='{$row['pname']} Image' style='max-width: 100px; max-height: 100px;'>";
    }
    $tableBody .= "</td>";
    $tableBody .= "<td>{$row['pcategory']}</td>";
    $tableBody .= "<td>{$row['saleprice']}</td>";
    $tableBody .= "<td>{$row['stock_quantity']}</td>";
    $tableBody .= "<td class='description-cell'><span class='description-content' onclick='toggleDescription(this)'>{$row['pdescription']}</span></td>";
    $tableBody .= "<td class='product-actions'>";
    $tableBody .= "<a href='#' class='edit-action' onclick='openEditModal({$row['pid']})'><ion-icon name='create-outline'></ion-icon></a>";
    $tableBody .= "<a href='#' class='delete-action' onclick='deleteProduct({$row['pid']})'><ion-icon name='trash-outline'></ion-icon></a>";
    $tableBody .= "</td>";
    $tableBody .= "</tr>";
    $count++;
}

// Build pagination links
$totalPagesSql = "SELECT CEIL(COUNT(*) / $productsPerPage) as totalPages FROM tbl_product";
$totalPagesResult = mysqli_query($conn, $totalPagesSql);
$totalPagesRow = mysqli_fetch_assoc($totalPagesResult);
$totalPages = $totalPagesRow['totalPages'];

$pagination = "";
if ($totalPages > 1) {
    $pagination .= "<br><br>";

    // Previous button
    if ($page > 1) {
        $pagination .= "<a href='#' onclick='fetchProducts(" . ($page - 1) . ")'>Previous</a>";
    }

    // Page numbers
    for ($i = 1; $i <= $totalPages; $i++) {
        if ($i == $page) {
            $pagination .= "<strong>{$i}</strong>";
        } else {
            $pagination .= "<a href='#' onclick='fetchProducts({$i})'>{$i}</a>";
        }
    }

    // Next button
    if ($page < $totalPages) {
        $pagination .= "<a href='#' onclick='fetchProducts(" . ($page + 1) . ")'>Next</a>";
    }
}

// Return the JSON response
echo json_encode([
    'tableBody' => $tableBody,
    'pagination' => $pagination,
]);


//view order//


if (isset($_GET['order_id'])) {
    $orderId = mysqli_real_escape_string($conn, $_GET['order_id']);
    
    // Fetch order details from the database
    $orderDetailsSql = "SELECT * FROM tbl_orders WHERE order_id = '$orderId'";
    $orderDetailsResult = mysqli_query($conn, $orderDetailsSql);

    if ($orderDetailsResult && $orderDetails = mysqli_fetch_assoc($orderDetailsResult)) {
        // Return order details as JSON
        header('Content-Type: application/json');
        echo json_encode($orderDetails);
    } else {
        // Handle error
        echo json_encode(['error' => 'Failed to fetch order details.']);
    }
} else {
    // Handle error
    echo json_encode(['error' => 'Order ID not provided.']);
}

// Close the database connection
mysqli_close($conn);














?>
