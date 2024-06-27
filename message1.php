<?php
// Include the database connection
include '../connections.php';

// Include the HTML header
include 'header.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="header">
        <div class="logo">
            <img src="BRL_logo.png" alt="BRL Trading Logo">
            <span>BRL Trading</span>
        </div>
        <div class="search-bar">
            <input type="text" placeholder="Search">
        </div>
        <div class="icons">
        <button type="button"><i class="fas fa-user"></i></button>
        </div>
        <div class="icons">
        <button type="button"><i class="fas fa-shopping-cart"></i></button>
        </div>
        <div class="icons">
        <button type="button"><i class="fas fa-heart"></i></button>
        </div>
        <div class="icons">
        <button type="button"><i class="fas fa-comment"></i></button>
        </div>
    </div>
    <nav>
    <ul>
        <li><a href="cleaning_solutions.php">Cleaning Solutions</a></li>
        <li><a href="custodial_and_equipment.php">Custodial and Equipment</a></li>
        <li><a href="paper_products.php">Paper Products</a></li>
        <li><a href="hotel_toiletries.php">Hotel Toiletries</a></li>
    </ul>
</nav>
    <div class="message-container">
        <div class="message-header">Message</div>
        <div class="message-box" id="message-box"></div>
        <div class="send-message">
            <input type="text" id="message-input" placeholder="Send a Message">
            <button onclick="sendMessage()">Send</button>
        </div>
    </div>
    <footer class="footer">
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
    </footer>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>
    <script src="script.js"></script>
</body>
</html>
