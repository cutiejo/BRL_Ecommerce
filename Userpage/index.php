<?php
include "../connections.php";

// Fetch products from the database
$sql = "SELECT * FROM tbl_product";
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
  <title>BRL Trading</title>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="../Admin/assets/imgs/logo_brl.png">
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel/slick/slick.css"/>
  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel/slick/slick-theme.css"/>
  
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
      <li><a href="cleaning_solutions.php">Cleaning Solutions</a>
        <!--<ul class="dropdown">
          <li><a href="#">Sub Item 1</a></li>
          <li><a href="#">Sub Item 2</a></li>
          <li><a href="#">Sub Item 3</a></li>
        </ul>-->
      </li>
      <li><a href="custodial_and_equipment.php">Custodial and Equipment</a>
        <!--<ul class="dropdown">
          <li><a href="#">Sub Item 1</a></li>
          <li><a href="#">Sub Item 2</a></li>
          <li><a href="#">Sub Item 3</a></li>
        </ul>-->
      </li>
      <li><a href="paper_products.php">Paper Products</a>
     <!-- <ul class="dropdown">
        <li><a href="paper_products.php">Tissue</a></li>
        <li><a href="paper_products.php">Dispenser</a></li>
        <li><a href="paper_products.php">Paper Cups</a></li>
      </ul>-->
    </li>
      <!--<li><a href="#">Trash Bags</a>
        <ul class="dropdown">
          <li><a href="#">Sub Item 1</a></li>
          <li><a href="#">Sub Item 2</a></li>
          <li><a href="#">Sub Item 3</a></li>
        </ul>
      </li>-->
      <li><a href="hotel_toiletries.php">Hotel Toiletries</a>
        <!--<ul class="dropdown">
          <li><a href="#">Sub Item 1</a></li>
          <li><a href="#">Sub Item 2</a></li>
          <li><a href="#">Sub Item 3</a></li>
        </ul>-->
      </li>
    </ul>
  </nav>
  
  <!-- Carousel Section -->
  <div class="carousel-section">
    <div class="carousel">
      <div class="carousel-item"><img src="../Userpage/images/11.png" alt="Carousel Image 1" object-fit="cover"></div>
      <div class="carousel-item"><img src="../Userpage/images/1.png" alt="Carousel Image 2"></div>
      <div class="carousel-item"><img src="../LOGIN/img/pic1.png" alt="Carousel Image 3"></div>
    </div>
  </div>

    <!-- Our Products Section -->
    <div class="our-products-section">
      <h2>Our Products</h2>
      <div class="product-grid">
        <div class="product-item">
          <div class="product-image">
            <img src="./images/cleaning.png" alt="Cleaning and Laundry Solutions">
          </div>
          <p class="product-title">CLEANING AND LAUNDRY SOLUTIONS</p>
          <div class="product-description">
            <p>Effectively removes moss and mildew and other stain. It is best used to clean concrete surfaces with AG formulations and bioculture.</p>
          </div>
          <a href="#" class="see-more">See more</a>
        </div>
        <div class="product-item">
          <div class="product-image">
            <img src="./images/janitorial.png" alt="Janitorial and Housekeeping Supplies">
          </div>
          <p class="product-title">JANITORIAL AND HOUSEKEEPING SUPPLIES</p>
          <div class="product-description">
            <p>Quality commercial equipment and supplies. Includes chemical pumps, waste bins, hand dryers, brooms, brushes, carts, mops, and floor machines. These are designed to provide optimum performance, maneuverability, and durability.</p>
          </div>
          <a href="#" class="see-more">See more</a>
        </div>
        <div class="product-item">
          <div class="product-image">
            <img src="./images/tissue.png" alt="Paper Products">
          </div>
          <p class="product-title">PAPER PRODUCTS</p>
          <div class="product-description">
            <p>Eco-friendly, budget-friendly, and good quality paper tissue. These are made in Mexico. All categories include hand towels and toilet paper.</p>
          </div>
          <a href="#" class="see-more">See more</a>
        </div>
        <div class="product-item">
          <div class="product-image">
            <img src="./images/toileters.png" alt="Hotel Toiletries">
          </div>
          <p class="product-title">HOTEL TOILETRIES</p>
          <div class="product-description">
            <p>Our products are various ranging from bathroom accessories, hygienic products to cosmetic accessories.</p>
          </div>
          <a href="#" class="see-more">See more</a>
        </div>
      </div>
    </div>
  </main>


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

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel/slick/slick.min.js"></script>
  <script>
    $(document).ready(function(){
      $('.carousel').slick({
        infinite: true,
        slidesToShow: 1,
        slidesToScroll: 1,
        dots: true,
        arrows: false,
        autoplay: true,
        autoplaySpeed: 3000,
        appendDots: $(".carousel-section"),
        dotsClass: "slick-dots custom-dots",
        responsive: [
          {
            breakpoint: 768,
            settings: {
              slidesToShow: 1,
              slidesToScroll: 1
            }
          },
          {
            breakpoint: 480,
            settings: {
              slidesToShow: 1,
              slidesToScroll: 1
            }
          }
        ]
      });

      $('.see-more').on('click', function(e) {
        e.preventDefault();
        $(this).prev('.product-description').toggleClass('expanded');
        $(this).text($(this).text() === 'See more' ? 'See less' : 'See more');
      });

      // Dropdown functionality
      $('nav ul li').hover(
        function() {
          $(this).children('.dropdown').stop(true, false, true).slideToggle(300);
        }
      );
    });
  </script>
</body>
</html>
