<?php
include "../connections.php";

// Fetch products from the "Custodial and Equipment" category (assuming the category id for "Custodial and Equipment" is 30)
$sql = "SELECT * FROM tbl_product WHERE pcategory = 74";
$result = $conn->query($sql);

$products = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>BRL Trading - Custodial and Equipment</title>
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
    <a href="index.php">
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
      <li><a href="cleaning_solutions.php">Cleaning Solutions</a></li>
      <li><a href="custodial_and_equipment.php">Custodial and Equipment</a></li>
      <li><a href="paper_products.php">Paper Products</a></li>
      <li><a href="hotel_toiletries.php">Hotel Toiletries</a></li>
    </ul>
  </nav>
  
  <!-- Products Section -->
  <div class="our-products-section">
    <h2>Custodial and Equipment</h2>
    <div class="product-grid">
      <?php if (empty($products)): ?>
        <p>No products found in this category.</p>
      <?php else: ?>
        <?php foreach ($products as $product): ?>
        <div class="product-item">
          <div class="product-image">
            <?php
            $imagePath = "../Admin/" . $product['pimage']; // Updated path to match the directory structure
            if (file_exists($imagePath)) {
                echo "<img src='$imagePath' alt='{$product['pname']}'>";
            } else {
                echo "<p>Image not found: $imagePath</p>";
            }
            ?>
          </div>
          <p class="product-title"><?php echo $product['pname']; ?></p>
          <p class="product-price">₱ <?php echo number_format($product['saleprice'], 2); ?></p>
        </div>
        <?php endforeach; ?>
      <?php endif; ?>
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

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel/slick/slick.min.js"></script>
  <script>

      // Dropdown functionality
      $('nav ul li').hover(
        function() {
          $(this).children('.dropdown').stop(true, false, true).slideToggle(300);
        }
      );
  
  </script>

</body>
</html>
