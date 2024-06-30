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
            <!--<h3>Message for Seller</h3>
            <p>Please secure the package and make sure to double wrap it, thanks.</p>-->
            <hr>
            <h3>Payment Option</h3>
            <p>Cash on Delivery</p>
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
            <form action="place_order.php" method="post">
                <?php for ($i = 0; $i < count($product_ids); $i++): ?>
                <input type="hidden" name="product_ids[]" value="<?php echo htmlspecialchars($product_ids[$i]); ?>">
                <input type="hidden" name="product_names[]" value="<?php echo htmlspecialchars($product_names[$i]); ?>">
                <input type="hidden" name="product_images[]" value="<?php echo htmlspecialchars($product_images[$i]); ?>">
                <input type="hidden" name="product_prices[]" value="<?php echo htmlspecialchars($product_prices[$i]); ?>">
                <input type="hidden" name="quantities[]" value="<?php echo htmlspecialchars($quantities[$i]); ?>">
                <?php endfor; ?>
                <button class="btn-place-order" type="submit">Place Order</button>
            </form>
        </div>
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
