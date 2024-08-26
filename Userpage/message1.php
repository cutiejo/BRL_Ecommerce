<?php
session_start();
include '../connections.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../LOGIN/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BRL Trading - User Messages</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="style_mssg.css">
    <link rel="icon" href="../Admin/assets/imgs/logo_brl.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel/slick/slick.css"/>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel/slick/slick-theme.css"/>
</head>
<body>
<style>
.file-upload-icon {
    cursor: pointer;
    font-size: 1.5em;
    margin-left: 10px;
    margin-right: 10px;
    display: inline-block;
}
.message-wrapper-right {
    text-align: right;
}
.message-wrapper-left {
    text-align: left;
}
.message-blue {
    display: inline-block;
    padding: 10px;
    border-radius: 10px;
    background-color: #d9edf7;
    margin: 5px 0;
}
.message-blue img {
    background-color: transparent;
    display: block;
}
.timestamp {
    font-size: 0.8em;
    color: #888;
}
</style>
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
                    <button type="button"><i class="fas fa-shopping-cart"></i></button>
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

<div class="message-container">
    <div class="message-header">Messages</div>
    <div class="message-box" id="message-box"></div>
    <div id="file-preview" style="margin-bottom: 10px;"></div> <!-- File preview above the input area -->
    <div class="send-message">
        <label for="file-input" class="file-upload-icon">
            <i class="fas fa-paperclip"></i>
        </label>
        <input type="file" id="file-input" style="display: none;" onchange="previewFile()">
        <input type="text" id="message-input" placeholder="Send a Message">
        <button onclick="sendMessage()">Send</button>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    loadMessages();
});

function previewFile() {
    var fileInput = document.getElementById("file-input");
    var filePreview = document.getElementById("file-preview");
    filePreview.innerHTML = ""; // Clear previous preview

    if (fileInput.files && fileInput.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            var fileElement = document.createElement("img");
            fileElement.src = e.target.result;
            fileElement.style.maxWidth = "100px"; // Adjust size as needed
            filePreview.appendChild(fileElement);
            filePreview.style.display = "block";
        };
        reader.readAsDataURL(fileInput.files[0]);
    } else {
        filePreview.style.display = "none";
    }
}

function sendMessage() {
    var messageInput = document.getElementById("message-input");
    var fileInput = document.getElementById("file-input");
    var message = messageInput.value;
    var file = fileInput.files[0];

    if (message.trim() === "" && !file) {
        return;
    }

    var formData = new FormData();
    formData.append("message", message);
    if (file) {
        formData.append("file", file);
    }

    fetch("send_message1.php", {
        method: "POST",
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            messageInput.value = "";
            fileInput.value = "";
            document.getElementById("file-preview").style.display = "none";
            loadMessages();
        } else {
            console.error(data.debug); // Log the debug information
            alert("Error sending message: " + data.debug);
        }
    })
    .catch(error => console.error("Error:", error));
}

function loadMessages() {
    fetch("fetch_messages1.php")
    .then(response => response.json())
    .then(data => {
        var messageBox = document.getElementById("message-box");
        messageBox.innerHTML = "";
        data.messages.forEach(message => {
            var messageWrapper = document.createElement("div");
            messageWrapper.className = message.user_id == <?php echo $user_id; ?> ? "message-wrapper-right" : "message-wrapper-left";

            var timestampElement = document.createElement("div");
            timestampElement.className = "timestamp";
            var date = new Date(message.created_at);
            timestampElement.textContent = date.toLocaleString(); // Adjust the format as needed
            messageWrapper.appendChild(timestampElement);

            var messageElement = document.createElement("div");
            if (message.file) {
                var fileElement = document.createElement("a");
                fileElement.href = message.file;
                fileElement.target = "_blank";
                var fileIcon = document.createElement("img");
                fileIcon.src = message.file;
                fileIcon.style.maxWidth = "100px"; // Adjust size as needed
                fileElement.appendChild(fileIcon);
                messageElement.appendChild(fileElement);
            } else {
                messageElement.className += " message-blue"; // Apply background only to text messages
                var textElement = document.createElement("div");
                textElement.textContent = message.message;
                messageElement.appendChild(textElement);
            }
            messageWrapper.appendChild(messageElement);
            messageBox.appendChild(messageWrapper);
        });
    })
    .catch(error => console.error("Error:", error));
}

function sendMessage() {
    var messageInput = document.getElementById("message-input");
    var fileInput = document.getElementById("file-input");
    var message = messageInput.value;
    var file = fileInput.files[0];

    if (message.trim() === "" && !file) {
        return;
    }

    var formData = new FormData();
    formData.append("message", message);
    if (file) {
        formData.append("file", file);
    }

    fetch("send_message1.php", {
        method: "POST",
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            messageInput.value = "";
            fileInput.value = "";
            document.getElementById("file-preview").style.display = "none";
            loadMessages();
        } else {
            console.error(data.debug); // Log the debug information
            alert("Error sending message: " + data.debug);
        }
    })
    .catch(error => console.error("Error:", error));
}

</script>
</body>
</html>
