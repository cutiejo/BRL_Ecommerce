<?php
include "../connections.php";
session_start();

// Check if the user is logged in, if not then redirect to login page
if (!isset($_SESSION['useremail'])) {
    header("Location: ../LOGIN/login.php");
    exit();
}
// Fetch the user_id from the session
$user_id = $_SESSION['user_id'];

// Fetch cart items from the database
$sql = "SELECT c.cart_id, c.quantity, p.pid, p.pname, p.saleprice, p.pimage FROM tbl_cart c JOIN tbl_product p ON c.product_id = p.pid WHERE c.user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$cart_items = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $cart_items[] = $row;
    }
}
$stmt->close();
?>
<!DOCTYPE html>
<html>
<head>
    <title>BRL Trading - Cart</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        .cart-container {
            width: 70%;
            margin: auto;
            background-color: white;
            padding: 50px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            margin-top: 120px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 15px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
        }
        td img {
            width: 50px;
            height: auto;
        }
        .btn-delete {
            background-color: red;
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
            border-radius: 4px;
        }
        .cart-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 0;
        }
        .total-price-footer {
            margin-left: 620px;
        }
        .btn-checkout {
            background-color: #ff9800;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 4px;
        }
        .quantity {
            display: inline-block;
            width: 30px;
            text-align: center;
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
<!-- Cart Section -->
<div class="cart-container">
    <table>
        <thead>
            <tr>
                <th></th>
                <th>Product</th>
                <th>Unit Price</th>
                <th>Quantity</th>
                <th>Total Price</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($cart_items as $item): ?>
                <tr data-cart-id="<?php echo $item['cart_id']; ?>">
                    <td><input type="checkbox" class="select-item" onchange="updateGrandTotal()"></td>
                    <td><img src="../Admin/<?php echo $item['pimage']; ?>" alt="<?php echo $item['pname']; ?>" data-product-id="<?php echo $item['pid']; ?>"> <?php echo $item['pname']; ?></td>
                    <td class="unit-price"><?php echo number_format($item['saleprice'], 2); ?></td>
                    <td>
                        <button onclick="updateQuantity(this, -1)">−</button>
                        <span class="quantity"><?php echo $item['quantity']; ?></span>
                        <button onclick="updateQuantity(this, 1)">+</button>
                    </td>
                    <td class="total-price"><?php echo number_format($item['saleprice'] * $item['quantity'], 2); ?></td>
                    <td><button class="btn-delete" onclick="deleteRow(this)">Delete</button></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="cart-footer">
        <div>
            <input type="checkbox" onclick="selectAll(this)"> Select all 
            <button onclick="deleteSelected()">Delete</button>
        </div>
        <div class="total-price-footer">TOTAL: ₱<span id="grand-total">0.00</span></div>
        <button class="btn-checkout" onclick="proceedToCheckout()">Check Out</button>
    </div>
</div>

<script>
    function updateQuantity(element, amount) {
        var row = element.parentElement.parentElement;
        var quantitySpan = row.querySelector('.quantity');
        var unitPrice = parseFloat(row.querySelector('.unit-price').textContent.replace(/,/g, ''));
        var quantity = parseInt(quantitySpan.textContent) + amount;
        if (quantity >= 1) { // Ensure quantity is at least 1
            quantitySpan.textContent = quantity;
            var totalPrice = unitPrice * quantity;
            row.querySelector('.total-price').textContent = totalPrice.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
            updateGrandTotal();

            // Update quantity in the database
            var cartId = row.getAttribute('data-cart-id');
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "update_cart_quantity.php", true);
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhr.send("cart_id=" + cartId + "&quantity=" + quantity);
        }
    }

    function deleteRow(element) {
        var row = element.parentElement.parentElement;
        var cartId = row.getAttribute('data-cart-id');
        row.parentElement.removeChild(row);
        updateGrandTotal();

        // Remove from the database
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "remove_from_cart.php", true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.send("cart_id=" + cartId);
    }

    function deleteSelected() {
        var checkboxes = document.querySelectorAll('tbody .select-item:checked');
        checkboxes.forEach(function(checkbox) {
            var row = checkbox.parentElement.parentElement;
            var cartId = row.getAttribute('data-cart-id');
            row.parentElement.removeChild(row);

            // Remove from the database
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "remove_from_cart.php", true);
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhr.send("cart_id=" + cartId);
        });
        updateGrandTotal();
    }

    function selectAll(element) {
        var checkboxes = document.querySelectorAll('tbody .select-item');
        checkboxes.forEach(function(checkbox) {
            checkbox.checked = element.checked;
        });
        updateGrandTotal();
    }

    function updateGrandTotal() {
        var total = 0;
        var checkboxes = document.querySelectorAll('tbody .select-item:checked');
        checkboxes.forEach(function(checkbox) {
            var row = checkbox.parentElement.parentElement;
            var totalPrice = parseFloat(row.querySelector('.total-price').textContent.replace(/,/g, ''));
            total += totalPrice;
        });
        document.getElementById('grand-total').textContent = total.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
    }

    function proceedToCheckout() {
        // Redirect to checkout page with selected items
        var checkboxes = document.querySelectorAll('tbody .select-item:checked');
        if (checkboxes.length > 0) {
            var form = document.createElement('form');
            form.method = 'POST';
            form.action = 'checkout.php';

            checkboxes.forEach(function(checkbox) {
                var row = checkbox.parentElement.parentElement;
                var productId = row.querySelector('td img').getAttribute('data-product-id');
                var productName = row.querySelector('td img').alt;
                var productImage = row.querySelector('td img').src;
                var productPrice = parseFloat(row.querySelector('.unit-price').textContent.replace(/,/g, ''));
                var quantity = parseInt(row.querySelector('.quantity').textContent);

                form.appendChild(createHiddenInput('product_ids[]', productId));
                form.appendChild(createHiddenInput('product_names[]', productName));
                form.appendChild(createHiddenInput('product_images[]', productImage));
                form.appendChild(createHiddenInput('product_prices[]', productPrice));
                form.appendChild(createHiddenInput('quantities[]', quantity));
            });

            document.body.appendChild(form);
            form.submit();
        } else {
            alert("Please select at least one item to proceed to checkout.");
        }
    }

    function createHiddenInput(name, value) {
        var input = document.createElement('input');
        input.type = 'hidden';
        input.name = name;
        input.value = value;
        return input;
    }

    // Initialize grand total on page load
    document.addEventListener('DOMContentLoaded', function() {
        updateGrandTotal();
    });
</script>

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
</div>
</body>
</html>
