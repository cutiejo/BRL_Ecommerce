

<?php
include "../connections.php";

// Start the session
session_start();

// Get the user ID from the session
$user_id = $_SESSION['user_id'];
// Fetch the order details stored in the session
$orderDetails = isset($_SESSION['orderDetails']) ? $_SESSION['orderDetails'] : [];

if (empty($orderDetails)) {
    die("No orders found for this user.");
}

// Calculate the total price including the shipping cost
$grandTotal = array_sum(array_column($orderDetails, 'total_price'));
$shippingCost = 50; // Fixed shipping cost
$totalPayment = $grandTotal + $shippingCost;
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 80%;
            max-width: 1200px;
            margin: 50px auto;
            background-color: #fff;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            padding: 20px;
            overflow: hidden;
            margin-top: 150px;
        }

        .container .p .h{
            align-items:center;
        }
        h1 {
            color: #4CAF50;
            text-align: center;
            margin-bottom: 20px;
            
        }
        .order-summary {
            margin: 20px 0;
            
        }
        .order-summary h2 {
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        th, td {
            padding: 15px;
            text-align: left;
        }
        th {
            background-color: #343a40;
            color: #fff;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        tr img {
            padding: 15px;
            max-width: 50px;
        }
        .img {
            max-width: 10px;
        }
        .total-price {
            font-size: 15px;
            font-weight: bold;
            text-align: right;
            margin-top: 20px;
            
        }
        .back-to-home {
            display: block;
            width: fit-content;
            margin: 20px auto;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            text-align: center;
        }
        .back-to-home:hover {
            background-color: #45a049;
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
                    <a href="add_to_cart.php">
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
                    <a href="message.php">
                        <button type="button"><i class="fas fa-comment"></i></button>
                    </a>
                </div>
            </div>
        </div>
    </header>
    <nav>
        <ul>
            <li><a href="cleaning_solutions.php">Cleaning Solutions</a></li>
            <li><a href="custodial_and_equipment.php">Custodial and Equipment</a></li>
            <li><a href="paper_products.php">Paper Products</a></li>
            <li><a href="hotel_toiletries.php">Hotel Toiletries</a></li>
        </ul>
    </nav>

    <div class="container">
        <h1>Order Confirmation</h1>
        <p>Thank you for your purchase! Your order has been placed successfully.</p>

        <div class="order-summary">
            <h2>Order Summary</h2>
            <table>
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Unit Price</th>
                        <th>Quantity</th>
                        <th>Total Price</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orderDetails as $item): ?>
                    <tr>
                        <td><img src="<?php echo htmlspecialchars($item['product_image']); ?>" alt="<?php echo htmlspecialchars($item['product_name']); ?>"> <?php echo htmlspecialchars($item['product_name']); ?></td>
                        <td>₱<?php echo number_format($item['product_price'], 2); ?></td>
                        <td><?php echo htmlspecialchars($item['quantity']); ?></td>
                        <td>₱<?php echo number_format($item['total_price'], 2); ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <div class="total-price">
                Total: ₱<?php echo number_format($grandTotal, 2); ?>
            </div>
            <div class="total-price">
                Shipping: ₱<?php echo number_format($shippingCost, 2); ?>
            </div>
            <div class="total-price">
                Grand Total: ₱<?php echo number_format($totalPayment, 2); ?>
            </div>
        </div>

        <p>We will send you an email with your order details shortly.</p>
        <a class="back-to-home" href="index.php">Back to Home</a>
    </div>

    <div class="footer">
        <div class="footer-content">
            <div class="footer-left">
                <img src="../Admin/assets/imgs/logo_brl.png" alt="BRL Trading Logo">
                <p>© 2015 BRL Trading Philippines</p>
            </div>
            <div class="footer-right">
                <div class="footer-section">
                    <h3>Call</h3>
                    <p>Cavite: (242) 5465 6757</p>
                    <p>Manila: (09) 67688 7686)</p>
                </div>
                <div class="footer-section">
                    <h3>Contact</h3>
                    <p><a href="mailto:sales@brl-trading.com">sales@brl-trading.com</a></p>
                    <p><a href="mailto:sales.brl.trading@gmail.com">sales.brl.trading@gmail.com</a></p>
                </div>
                <div class="footer-section">
                    <h3>Follow</h3>
                    <p><a href="#"><i class="fab fa-facebook-f"></i> BRL Trading</a></p>
                    <p><a href="#"><i class="fab fa-instagram"></i> brltrading</a></p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>