<?php
session_start();
include '../connections.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../LOGIN/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];


// Check database connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Pagination settings
$orders_per_page = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $orders_per_page;

// Fetch total number of orders
$sql_total = "SELECT COUNT(*) AS total FROM tbl_orders WHERE user_id = ?";
$stmt_total = $conn->prepare($sql_total);
if (!$stmt_total) {
    die("Query preparation failed: " . $conn->error);
}
$stmt_total->bind_param("i", $user_id);
$stmt_total->execute();
$result_total = $stmt_total->get_result();
$total_orders = $result_total->fetch_assoc()['total'];
$total_pages = ceil($total_orders / $orders_per_page);

// Fetch user orders for the current page
$sql = "SELECT o.order_id, p.pname AS product_name, o.order_date, o.quantity, o.price 
        FROM tbl_orders o
        JOIN tbl_product p ON o.product_id = p.pid
        WHERE o.user_id = ?
        LIMIT ?, ?";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("Query preparation failed: " . $conn->error);
}
$stmt->bind_param("iii", $user_id, $offset, $orders_per_page);
$stmt->execute();
$result = $stmt->get_result();
$orders = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $orders[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<title>BRL Trading</title>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="../Admin/assets/imgs/logo_brl.png">
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel/slick/slick.css"/>
  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel/slick/slick-theme.css"/>
    <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="css1/user_orders.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <style>
        /* Modal styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.4);
        }
        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 25%;
            text-align: center;
            border-radius: 8px;
        }
        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 20px;
            font-weight: bold;
        }
        .modal-header .close {
            cursor: pointer;
            font-size: 28px;
        }
        .modal-body {
            margin: 20px 0;
        }
        .modal-footer {
            display: flex;
            justify-content: space-around;
        }
        .modal-footer button {
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            font-size: 16px;
            border-radius: 5px;
        }
        .modal-footer .logout {
            background-color: red;
            color: white;
        }
        .modal-footer .cancel {
            background-color: #0275d8;
            color: white;
        }

        /* Table styles */
        .orders-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            font-size: 16px;
        }
        .orders-table th, .orders-table td {
            padding: 12px 15px;
            border: 1px solid #ddd;
            text-align: left;
        }
        .orders-table th {
            background-color: #f4f4f4;
            color: #333;
        }
        .orders-table tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        /* Pagination styles */
        .pagination {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }
        .pagination a {
            color: black;
            padding: 8px 16px;
            text-decoration: none;
            border: 1px solid #ddd;
            margin: 0 4px;
        }
        .pagination a.active {
            background-color: #0275d8;
            color: white;
            border: 1px solid #0275d8;
        }
        .pagination a:hover {
            background-color: #ddd;
        }
    </style>
</head>
<body>
<header>
    <div class="logo">
      <a href="index.php">
        <img src="../Admin/assets/imgs/logo_brl.png" alt="BRL Trading Logo">
      </a>
    </div>
    <div class="header-right">
      <div class="search">
        <input type="text" placeholder="Search">
        <button type="submit"><i class="fas fa-search"></i></button>
      </div>
      <div class="icons">
        <div class="icon user">
          <a href="user_details.php">
            <button type="button"><i class="fas fa-user"></i></button>
          </a>
        </div>
        <div class="icon cart">
          <a href="view_cart.php">
            <button type="button">
              <i class="fas fa-shopping-cart"></i>
            </button>
          </a>
        </div>
        <div class="icon wishlist">
          <a href="wishlist.php">
            <button type="button"><i class="fas fa-heart"></i></button>
          </a>
        </div>
        <div class="icon messages">
          <a href="message1.php">
            <button type="button"><i class="fas fa-comment"></i></button>
          </a>
        </div>
      </div>
    </div>
  </header>

<div class="main-content">
    <div class="sidebar">
        <br><br><br><br>
        <!-- ========== Logo ============  -->
        <a href="#" class="logo-box">
            <i class='bx bx-user'></i>
            <div class="logo-name">My Account</div>
        </a>

        <!-- ========== List ============  -->
        <ul class="sidebar-list">
            <li>
                <div class="title">
                    <a href="user_details.php" class="link">
                        <i class='bx bx-user-circle'></i>
                        <span class="name">Details</span>
                    </a>
                </div>
            </li>
            <li>
                <div class="title">
                    <a href="user_orders.php" class="link">
                        <i class='bx bx-cart'></i>
                        <span class="name">Orders</span>
                    </a>
                </div>
            </li>
            <li>
                <div class="title">
                    <a href="#" class="link" onclick="openLogoutModal()">
                        <i class='bx bx-log-out'></i>
                        <span class="name">Sign Out</span>
                    </a>
                </div>
            </li>
        </ul>
    </div>

    <!-- ============= Home Section =============== -->
    <br>
    <section class="home">
        <div class="container">
            <h2>My Orders</h2>
            <?php if (empty($orders)): ?>
                <p>No orders found.</p>
            <?php else: ?>
                <table class="orders-table">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Product Name</th>
                            <th>Order Date</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Total Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($orders as $order): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($order['order_id']); ?></td>
                                <td><?php echo htmlspecialchars($order['product_name']); ?></td>
                                <td><?php echo htmlspecialchars($order['order_date']); ?></td>
                                <td><?php echo htmlspecialchars($order['quantity']); ?></td>
                                <td>₱ <?php echo number_format($order['price'], 2); ?></td>
                                <td>₱ <?php echo number_format($order['price'] * $order['quantity'], 2); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <!-- Pagination -->
                <div class="pagination">
                    <?php if ($page > 1): ?>
                        <a href="?page=<?php echo $page - 1; ?>">&lt;</a>
                    <?php endif; ?>
                    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                        <a href="?page=<?php echo $i; ?>" class="<?php if ($i == $page) echo 'active'; ?>"><?php echo $i; ?></a>
                    <?php endfor; ?>
                    <?php if ($page < $total_pages): ?>
                        <a href="?page=<?php echo $page + 1; ?>">&gt;</a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </section>
</div>

<!-- Logout Modal -->
<div id="logoutModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <span>Logout</span>
            <span class="close" onclick="closeLogoutModal()">&times;</span>
        </div>
        <div class="modal-body">
            Are you sure you want to log out?
        </div>
        <div class="modal-footer">
            <button class="logout" onclick="confirmLogout()">Logout</button>
            <button class="cancel" onclick="closeLogoutModal()">Cancel</button>
        </div>
    </div>
</div>

<!-- Link JS -->
<script src="assets/js/main.js"></script>
<script>
    // Open logout modal
    function openLogoutModal() {
        document.getElementById('logoutModal').style.display = 'block';
    }

    // Close logout modal
    function closeLogoutModal() {
        document.getElementById('logoutModal').style.display = 'none';
    }

    // Confirm logout
    function confirmLogout() {
        window.location.href = 'logout.php';
    }
</script>
</body>
</html>
