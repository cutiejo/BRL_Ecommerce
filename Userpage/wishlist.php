<?php
session_start();
include '../connections.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../LOGIN/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];


$sql = "SELECT p.* FROM wishlist w JOIN tbl_product p ON w.product_id = p.pid WHERE w.user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$wishlist_items = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $wishlist_items[] = $row;
    }
}

$stmt->close();
$conn->close();
?>
<!DOCTYPE html>
<html>
<head>
  <title>BRL Trading</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="../Admin/assets/imgs/logo_brl.png">
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <style>
    .wishlist-container {
        width: 70%;
        margin: auto;
        margin-top:130px;
        background-color: white;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }
    .wishlist-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px 0;
        border-bottom: 1px solid #ddd;
    }
    .wishlist-item img {
        width: 50px;
        height: auto;
    }
    .wishlist-item .product-info {
        flex-grow: 1;
        margin-left: 20px;
    }
    .wishlist-item .product-info h4 {
        margin: 0;
    }
    .wishlist-item .product-info p {
        margin: 5px 0 0;
    }
    .wishlist-item .remove-wishlist {
        border: none;
        background: none;
        color: red;
        font-size: 24px;
        cursor: pointer;
    }
    .wishlist-item .remove-wishlist:hover {
        color: darkred;
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

  <!-- Wishlist Section -->
  <div class="wishlist-container">
    <h2>My Wishlist</h2>
    <?php if (empty($wishlist_items)): ?>
        <p>Your wishlist is empty.</p>
    <?php else: ?>
        <?php foreach ($wishlist_items as $item): ?>
            <div class="wishlist-item">
                <img src="<?php echo "../Admin/" . $item['pimage']; ?>" alt="<?php echo $item['pname']; ?>">
                <div class="product-info">
                    <h4><?php echo $item['pname']; ?></h4>
                    <p>₱ <?php echo number_format($item['saleprice'], 2); ?></p>
                </div>
                <button class="remove-wishlist" onclick="removeFromWishlist(<?php echo $item['pid']; ?>)"><i class="fas fa-heart"></i></button>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
  </div>

  <script>
    function removeFromWishlist(productId) {
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "remove_from_wishlist.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                location.reload();
            }
        };
        xhr.send("product_id=" + productId + "&user_id=<?php echo $user_id; ?>");
    }
  </script>

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
