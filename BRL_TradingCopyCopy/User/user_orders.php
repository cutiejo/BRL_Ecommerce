<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>

    <!-- Box Icons  -->
    <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
    <!-- Styles  -->
    <link rel="shortcut icon" href="assets/img/kxp_fav.png" type="image/x-icon">
    <link rel="icon" href="assets/img/logo_brl.png">
    <link rel="stylesheet" href="assets/css/user_orders.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel/slick/slick.css"/>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel/slick/slick-theme.css"/>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&family=Montserrat:wght@400;700&display=swap">

</head>

<body>
    <header>
        <div class="logo">
            <img src="assets/img/logo_brl.png" alt="BRL Trading Logo">
        </div>
        <div class="header-right">
            <div class="search">
                <input type="text" placeholder="Search">
                <button type="submit"><i class="fas fa-search"></i></button>
            </div>
            <div class="icons">
                <div class="icon user">
                    <button type="button"><i class="fas fa-user"></i></button>
                </div>
                <div class="icon cart">
                    <button type="button"><i class="fas fa-shopping-cart"></i></button>
                    <span class="badge"></span>
                </div>
                <div class="icon wishlist">
                    <button type="button"><i class="fas fa-heart"></i></button>
                </div>
                <div class="icon messages">
                    <button type="button"><i class="fas fa-comment"></i></button>
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
                <!-- -------- Non Dropdown List Item ------- -->
                <li>
                    <div class="title">
                        <a href="user_details.php" class="link">
                            <i class='bx bx-user-circle'></i>
                            <span class="name">Details</span>
                        </a>
                    </div>
                </li>

                <!-- -------- Non Dropdown List Item ------- -->
                <li>
                    <div class="title">
                        <a href="orders.php" class="link">
                            <i class='bx bx-cart'></i>
                            <span class="name">Orders</span>
                        </a>
                    </div>
                </li>

                <!-- -------- Non Dropdown List Item ------- -->
                <li>
                    <div class="title">
                        <a href="#" class="link">
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
            <div class="form-container">
                <h2>My Orders</h2>
                <div class="filter-buttons">
                    <button class="filter-btn" onclick="filterOrders('all')">All Orders</button>
                    <button class="filter-btn" onclick="filterOrders('completed')">Completed</button>
                    <button class="filter-btn" onclick="filterOrders('pending')">Pending</button>
                    <button class="filter-btn" onclick="filterOrders('cancelled')">Cancelled</button>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Order #</th>
                            <th>Product Name</th>
                            <th>Address</th>
                            <th>Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody id="orders-table">
                        <tr data-status="completed">
                            <td>1</td>
                            <td>#123456</td>
                            <td>
                                <img src="assets/img/paper.jpg" alt="Product Image" width="50" style="vertical-align: middle;">
                                <span style="vertical-align: middle;">Paper</span>
                            </td>
                            <td>123 Street, City</td>
                            <td>2024-06-20</td>
                            <td>Delivered</td>
                        </tr>
                        <tr data-status="pending">
                            <td>2</td>
                            <td>#789012</td>
                            <td><img src="assets/img/mop.jpg" alt="Product Image" width="50" style="vertical-align: middle;"> <span style="vertical-align: middle;">Mop</span>
                            <td>456 Avenue, City</td>
                            <td>2024-06-19</td>
                            <td>Shipped</td>
                        </tr>
                        <!-- Add more rows as needed -->
                    </tbody>
                </table>
            </div>
        </section>
    </div>

    <!-- Link JS -->
    <script src="assets/js/main.js"></script>
    <script>
        function filterOrders(status) {
            const rows = document.querySelectorAll('#orders-table tr');
            rows.forEach(row => {
                if (status === 'all' || row.getAttribute('data-status') === status) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }
    </script>
</body>

</html>
