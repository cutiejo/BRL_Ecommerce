<?php
include "../connections.php";

// Fetch product details from the database based on the product ID
$product_id = isset($_GET['pid']) ? intval($_GET['pid']) : 0;

$sql = "SELECT * FROM tbl_product WHERE pid = $product_id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $product = $result->fetch_assoc();
} else {
    echo "Product not found!";
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
  <title><?php echo htmlspecialchars($product['pname']); ?> - BRL Trading</title>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="../Admin/assets/imgs/logo_brl.png">
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
  <header>
    <div class="logo">
      <img src="../Admin/assets/imgs/logo_brl.png" alt="BRL Trading Logo">
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
  <nav>
    <ul>
      <li><a href="#">Cleaning Solutions</a>
        <ul class="dropdown">
          <li><a href="#">Sub Item 1</a></li>
          <li><a href="#">Sub Item 2</a></li>
          <li><a href="#">Sub Item 3</a></li>
        </ul>
      </li>
      <li><a href="#">Custodial and Equipment</a>
        <ul class="dropdown">
          <li><a href="#">Sub Item 1</a></li>
          <li><a href="#">Sub Item 2</a></li>
          <li><a href="#">Sub Item 3</a></li>
        </ul>
      </li>
      <li><a href="#">Paper Products</a>
        <ul class="dropdown">
          <li><a href="#">Tissue</a></li>
          <li><a href="#">Dispenser</a></li>
          <li><a href="#">Paper Cups</a></li>
        </ul>
      </li>
      <li><a href="#">Trash Bags</a>
        <ul class="dropdown">
          <li><a href="#">Sub Item 1</a></li>
          <li><a href="#">Sub Item 2</a></li>
          <li><a href="#">Sub Item 3</a></li>
        </ul>
      </li>
      <li><a href="#">Hotel Toiletries</a>
        <ul class="dropdown">
          <li><a href="#">Sub Item 1</a></li>
          <li><a href="#">Sub Item 2</a></li>
          <li><a href="#">Sub Item 3</a></li>
        </ul>
      </li>
    </ul>
  </nav>
  
  <div class="product-detail-section">
    <h2><?php echo htmlspecialchars($product['pname']); ?></h2>
    <div class="product-detail">
      <img src="./images/<?php echo htmlspecialchars($product['pimage']); ?>" alt="<?php echo htmlspecialchars($product['pname']); ?>">
      <p><?php echo htmlspecialchars($product['pdescription']); ?></p>
      <p>Price: <?php echo htmlspecialchars($product['saleprice']); ?></p>
      <p>Stock: <?php echo htmlspecialchars($product['stock_quantity']); ?></p>
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

</body>
</html>
