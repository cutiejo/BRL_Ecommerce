<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Messaging System</title>
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
            <i class="fas fa-user"></i>
            <i class="fas fa-shopping-cart"></i>
            <i class="fas fa-heart"></i>
        </div>
    </div>
    <div class="message-container">
        <div class="message-header">Message</div>
        <div class="message-box" id="message-box"></div>
        <div class="send-message">
            <input type="text" id="message-input" placeholder="Send a Message">
            <button onclick="sendMessage()">Send</button>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>
    <script src="script.js"></script>
</body>
</html>
