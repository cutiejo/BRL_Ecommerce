<?php
include "../connections.php";

// Start the session
session_start();

// Get the user ID from the session
$user_id = $_SESSION['user_id'];

// Fetch user details
$sql = "SELECT * FROM user_details WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$userDetails = $result->fetch_assoc();
$stmt->close();

// Initialize product details arrays
$product_ids = isset($_POST['product_ids']) ? $_POST['product_ids'] : [];
$product_names = isset($_POST['product_names']) ? $_POST['product_names'] : [];
$product_images = isset($_POST['product_images']) ? $_POST['product_images'] : [];
$product_prices = isset($_POST['product_prices']) ? $_POST['product_prices'] : [];
$quantities = isset($_POST['quantities']) ? $_POST['quantities'] : [];

// Check for single product data (from "Buy Now" button)
if (isset($_POST['product_id']) && !empty($_POST['product_id'])) {
    $product_ids[] = $_POST['product_id'];
    $product_names[] = $_POST['product_name'];
    $product_images[] = $_POST['product_image'];
    $product_prices[] = $_POST['product_price'];
    $quantities[] = $_POST['quantity'];
}

// Calculate totals
$grandTotal = 0;
for ($i = 0; $i < count($product_ids); $i++) {
    $grandTotal += $product_prices[$i] * $quantities[$i];
}
$shippingCost = 50; // Fixed shipping cost
$totalPayment = $grandTotal + $shippingCost;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #e6e6e6;
            margin: 0;
            padding: 0;
        }
        .container {
            margin: 10px auto;
            width: 80%;
            background-color: white;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 150px;
        }
        .checkout-section {
            display: flex;
            justify-content: space-between;
        }
        .checkout-section > div {
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 50%;
        }
        .checkout-section img {
            width: 100px;
            height: auto;
        }
        .btn-place-order {
            background-color: #00b3b3;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
        }
        .btn-place-order:hover {
            background-color: #009999;
        }
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
            padding-top: 60px;
        }
        .modal-content {
            background-color: #fefefe;
            margin: 5% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 500px;
            text-align: center;
            border-radius: 10px;
            position: relative;
            animation: slideIn 0.5s;
        }
        @keyframes slideIn {
            from {transform: translateY(-50px); opacity: 0;}
            to {transform: translateY(0); opacity: 1;}
        }
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            position: absolute;
            top: 10px;
            right: 20px;
        }
        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
        .check-icon {
            font-size: 50px;
            color: green;
            margin-bottom: 20px;
        }
        .modal-header {
            font-size: 24px;
            color: #000;
        
            padding: 8px;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
        }
        .modal-body {
            font-size: 18px;
            margin-bottom: 20px;
            padding: 20px;
        }
        .order-details table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .order-details th, .order-details td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        .order-details th {
            background-color: #f2f2f2;
        }
        .total {
            text-align: right;
            margin-top: 20px;
        }
        .btn-messaging {
            display: block;
            margin: 20px auto;
            padding: 10px 20px;
            background-color: #00b3b3;
            color: white;
            text-align: center;
            text-decoration: none;
            border-radius: 5px;
        }
        .btn-messaging:hover {
            background-color: #009999;
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
<nav>
    <ul>
        <li><a href="cleaning_solutions.php">Cleaning Solutions</a></li>
        <li><a href="custodial_and_equipment.php">Custodial and Equipment</a></li>
        <li><a href="paper_products.php">Paper Products</a></li>
        <li><a href="hotel_toiletries.php">Hotel Toiletries</a></li>
    </ul>
</nav>

<div class="container checkout-container" id="checkout-container">
    <div class="checkout-section">
        <div>
            <h3>Delivery Address</h3>
            <p><?php echo htmlspecialchars($userDetails['address']); ?></p>
            <hr>
            <h3>Payment Option</h3>
            <form id="payment-form">
                <input type="radio" id="cod" name="payment_option" value="cod" checked>
                <label for="cod">Cash on Delivery</label><br>
                <input type="radio" id="gcash" name="payment_option" value="gcash">
                <label for="gcash">GCash</label>
            </form>
            <hr>
            <p>Merchandise Subtotal: ₱<span id="subtotal"><?php echo number_format($grandTotal, 2); ?></span></p>
            <p>Shipping Subtotal: ₱<span id="shipping"><?php echo number_format($shippingCost, 2); ?></span></p>
            <h3>Total Payment: ₱<span id="total"><?php echo number_format($totalPayment, 2); ?></span></h3>
        </div>
        <div>
            <h3>Products</h3>
            <div id="product-list">
                <?php for ($i = 0; $i < count($product_ids); $i++): ?>
                <div>
                    <img src="<?php echo htmlspecialchars($product_images[$i]); ?>" alt="<?php echo htmlspecialchars($product_names[$i]); ?>">
                    <p><?php echo htmlspecialchars($product_names[$i]); ?></p>
                    <p>₱ <?php echo number_format($product_prices[$i], 2); ?> x <?php echo htmlspecialchars($quantities[$i]); ?></p>
                </div>
                <?php endfor; ?>
            </div>
            <hr>
            <h3>Total Payment</h3>
            <p style="color: red; font-size: 24px;">₱ <span id="total-checkout"><?php echo number_format($totalPayment, 2); ?></span></p>
            <form id="order-form" action="place_order.php" method="post">
                <?php for ($i = 0; $i < count($product_ids); $i++): ?>
                <input type="hidden" name="product_ids[]" value="<?php echo htmlspecialchars($product_ids[$i]); ?>">
                <input type="hidden" name="product_names[]" value="<?php echo htmlspecialchars($product_names[$i]); ?>">
                <input type="hidden" name="product_images[]" value="<?php echo htmlspecialchars($product_images[$i]); ?>">
                <input type="hidden" name="product_prices[]" value="<?php echo htmlspecialchars($product_prices[$i]); ?>">
                <input type="hidden" name="quantities[]" value="<?php echo htmlspecialchars($quantities[$i]); ?>">
                <?php endfor; ?>
                <input type="hidden" name="payment_option" id="payment-option-hidden" value="cod">
                <button class="btn-place-order" type="submit" onclick="checkPaymentOption(event)">Place Order</button>
            </form>
        </div>
    </div>
</div>

<!-- GCash Modal -->
<div id="gcashModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">GCash Payment Confirmation</div>
        <span class="close" onclick="closeModal()">&times;</span>
        <div class="modal-body">
            <i class="fas fa-check-circle check-icon"></i>
            <p>Your order has been placed. Please send your GCash payment proof to our messaging system.</p>
        </div>
        <div class="order-details">
            <h3>Order Details</h3>
            <table>
                <thead>
                    <tr>
                        <th>Product Name</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Total Price</th>
                    </tr>
                </thead>
                <tbody id="order-details-body">
                    <!-- Order details will be populated here by JavaScript -->
                </tbody>
            </table>
            <div class="total">
                <p><strong>Grand Total: ₱ <span id="grand-total"></span></strong></p>
            </div>
        </div>
        <a href="message1.php" class="btn-messaging">Go to Messaging</a>
    </div>
</div>

<!-- Footer Section -->
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
                <p>Manila: (09) 67688 7686</p>
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

<script>
    document.getElementById('payment-form').addEventListener('change', function(e) {
        document.getElementById('payment-option-hidden').value = e.target.value;
    });

    function checkPaymentOption(event) {
        var paymentOption = document.getElementById('payment-option-hidden').value;
        if (paymentOption === 'gcash') {
            event.preventDefault();
            // Populate the order details in the modal
            var orderDetailsBody = document.getElementById('order-details-body');
            var grandTotal = 0;

            <?php for ($i = 0; $i < count($product_ids); $i++): ?>
                var productName = "<?php echo htmlspecialchars($product_names[$i]); ?>";
                var quantity = <?php echo htmlspecialchars($quantities[$i]); ?>;
                var productPrice = <?php echo htmlspecialchars($product_prices[$i]); ?>;
                var totalPrice = quantity * productPrice;
                grandTotal += totalPrice;

                var row = "<tr>";
                row += "<td>" + productName + "</td>";
                row += "<td>" + quantity + "</td>";
                row += "<td>₱ " + productPrice.toFixed(2) + "</td>";
                row += "<td>₱ " + totalPrice.toFixed(2) + "</td>";
                row += "</tr>";

                orderDetailsBody.innerHTML += row;
            <?php endfor; ?>
            grandTotal += <?php echo $shippingCost; ?>; // Add the shipping cost to the grand total

            document.getElementById('grand-total').textContent = grandTotal.toFixed(2);

            document.getElementById('gcashModal').style.display = "block";
        }
    }

    function closeModal() {
        document.getElementById('gcashModal').style.display = "none";
        document.getElementById('order-form').submit();
    }

    window.onclick = function(event) {
        var modal = document.getElementById('gcashModal');
        if (event.target === modal) {
            modal.style.display = "none";
        }
    }
</script>
</body>
</html>
