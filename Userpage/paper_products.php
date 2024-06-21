<?php
include "../connections.php";

// Fetch products from the "Paper Products" category (assuming the category id for "Paper Products" is 72)
$sql = "SELECT * FROM tbl_product WHERE pcategory = 72";
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
  <title>BRL Trading - Paper Products</title>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="../Admin/assets/imgs/logo_brl.png">
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <style>
    .modal {
      display: none;
      position: fixed;
      z-index: 1;
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
      width: 40%;
      max-width: 600px;
      display: flex;
      height: 300px; /* Fixed height for the modal */
      position: relative;
    }
    .close {
      color: #aaa;
      font-size: 28px;
      font-weight: bold;
      position: absolute;
      top: 10px;
      right: 20px; /* Adjust as needed */
    }
    .close:hover,
    .close:focus {
      color: black;
      text-decoration: none;
      cursor: pointer;
    }
    .modal-product-image {
      width: 50%;
      display: flex;
      justify-content: center;
      align-items: center;
    }
    .modal-product-image img {
      width: 100%;
      height: auto;
      max-height: 300px; /* Consistent height for images */
      object-fit: contain;
    }
    .modal-product-info {
      width: 50%;
      padding: 20px;
      display: flex;
      flex-direction: column;
      justify-content: center;
    }
    .modal-product-title{
      font-weight:bold;
    }
    .wishlist.active {
      color: red;
    }
    .modal-product-actions {
      display: flex;
      justify-content: space-around;
      align-items: center;
      margin-top: 20px;
    }
    .modal-product-quantity {
      display: flex;
      align-items: center;
      margin-top: 20px;
    }
    .modal-product-quantity input {
      width: 50px;
      text-align: center;
      margin: 0 10px;
    }
    .wishlist {
      
      border: none;
      font-size: 24px;
    }
    .wishlist:hover {
      cursor: pointer;
    }
    .add-to-cart,
    .buy-now {
      padding: 10px 20px;
      border: none;
      cursor: pointer;
      font-size: 16px;
    }
    .add-to-cart {
      background-color: #5cb85c;
      color: white;
    }
    .buy-now {
      background-color: #0275d8;
      color: white;
    }
  </style>
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
    <h2>Paper Products</h2>
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
                echo "<img src='$imagePath' alt='{$product['pname']}' onclick='openModal(\"{$product['pid']}\")'>";
            } else {
                echo "<p>Image not found: $imagePath</p>";
            }
            ?>
          </div>
          <p class="product-title"><?php echo $product['pname']; ?></p>
          <p class="product-price">₱ <?php echo number_format($product['saleprice'], 2); ?></p>
        </div>

        <!-- Modal -->
        <div id="modal-<?php echo $product['pid']; ?>" class="modal">
          <div class="modal-content">
            <span class="close" onclick="closeModal('<?php echo $product['pid']; ?>')">&times;</span>
            <div class="modal-product-image">
              <img src="<?php echo $imagePath; ?>" alt="<?php echo $product['pname']; ?>">
            </div>
            <div class="modal-product-info">
              <p class="modal-product-title"><?php echo $product['pname']; ?></p>
              <p class="modal-product-price">₱ <?php echo number_format($product['saleprice'], 2); ?></p>
              <div class="modal-product-quantity">
                <label for="quantity-<?php echo $product['pid']; ?>">Quantity</label>
                <input type="number" id="quantity-<?php echo $product['pid']; ?>" name="quantity" value="1" min="1">
              </div>
              <div class="modal-product-actions">
                <button class="wishlist" onclick="toggleWishlist(this)"><i class="fas fa-heart"></i></button>
                <button class="add-to-cart" onclick="addToCart(<?php echo $product['pid']; ?>)">Add to Cart</button>
                <button class="buy-now" onclick="buyNow(<?php echo $product['pid']; ?>)">Buy Now</button>
              </div>
            </div>
          </div>
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
    // Open modal
    function openModal(productId) {
      $('#modal-' + productId).css('display', 'block');
    }

    // Close modal
    function closeModal(productId) {
      $('#modal-' + productId).css('display', 'none');
    }

    // Toggle wishlist
    function toggleWishlist(element) {
      $(element).toggleClass('active');
    }

    // Add to cart
    function addToCart(productId) {
      var quantity = $('#quantity-' + productId).val();
      // Add to cart logic
      console.log('Added to cart:', productId, 'Quantity:', quantity);
    }

    // Buy now
    function buyNow(productId) {
      var quantity = $('#quantity-' + productId).val();
      // Buy now logic
      console.log('Buy now:', productId, 'Quantity:', quantity);
    }

    // Dropdown functionality
    $('nav ul li').hover(
      function() {
        $(this).children('.dropdown').stop(true, false, true).slideToggle(300);
      }
    );
  </script>
</body>
</html>
