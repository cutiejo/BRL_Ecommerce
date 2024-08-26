<?php
include '../connections.php'; 
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cashier</title>
    <!-- ======= Styles ====== -->
    <link rel="stylesheet" href="./assets/css/style.css">
    <!-- Include the styles and scripts from nav.php -->
    <?php include("nav.php"); ?>
    <!-- ======= Font Awesome for icons ====== -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<style>
    .container {
        display: flex;
        width: 100%;
    }

    .message-container {
        display: flex;
        flex: 1;
        height: 85vh;
    }

    .user-list-container {
        width: 300px;
        margin-left: 20px;
        background-color: white;
        border-right: 1px solid #ddd;
        display: flex;
        flex-direction: column;
        overflow-y: auto;
    }

    .user-list-container .search-bar {
        padding: 10px;
        border-bottom: 1px solid #ddd;
    }

    .user-list-container .search-bar input {
        width: 100%;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 20px;
    }

    .user-list-container .user-list {
        flex: 1;
        overflow-y: auto;
    }

    .user-list-item {
        display: flex;
        align-items: center;
        padding: 10px;
        border-bottom: 1px solid #ddd;
        cursor: pointer;
    }

    .user-list-item:hover {
        background-color: #f4f4f4;
    }

    .user-list-item img {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        margin-right: 10px;
    }

    .user-info {
        flex: 1;
    }

    .message-box-container {
        flex: 1;
        display: flex;
        flex-direction: column;
        padding: 20px;
    }

    .message-header {
        font-size: 1.5em;
        font-weight: bold;
        margin-bottom: 20px;
        text-align: center;
    }

    .message-box {
        flex: 1;
        overflow-y: auto;
        padding: 20px;
        background-color: #fff;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .message-wrapper {
        display: flex;
        flex-direction: column;
        margin-bottom: 10px;
    }

    .message-wrapper-right {
        align-items: flex-end;
    }

    .message-wrapper-left {
        align-items: flex-start;
    }

    .timestamp {
        font-size: 0.8em;
        color: #888;
        margin-bottom: 2px;
    }

    .message {
        padding: 10px;
        border-radius: 20px;
        display: inline-block;
        max-width: 80%;
        word-wrap: break-word;
        white-space: pre-wrap;
    }

    .message-blue {
        background-color: #007bff;
        color: white;
    }

    .message-grey {
        background-color: #f4f4f4;
        color: black;
    }

    .send-message {
        display: flex;
        align-items: center;
        padding: 10px 0;
        width: 100%;
    }

    .send-message input {
        flex: 1;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 20px;
        margin-right: 10px;
        box-sizing: border-box;
    }

    .send-message button {
        background-color: #007bff;
        border: none;
        color: white;
        padding: 10px;
        border-radius: 50%;
        cursor: pointer;
        flex-shrink: 0;
    }
</style>

<body>
<div class="message-container">
    <div class="user-list-container">
        <div class="search-bar">
            <input type="text" id="user-search" placeholder="Search users...">
        </div>
        <div class="user-list" id="user-list">
            <?php
            include '../connections.php';
            $query = "SELECT DISTINCT u.user_id, u.username FROM users u JOIN messages m ON u.user_id = m.user_id WHERE m.receiver_id = 1";
            $result = mysqli_query($conn, $query);
            if ($result) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<div class="user-list-item" onclick="loadMessages(' . $row['user_id'] . ', \'' . $row['username'] . '\')">';
                    echo '<img src="../Admin/assets/imgs/customer01.png" alt="Avatar">';
                    echo '<div class="user-info">';
                    echo '<div class="user-name">' . $row['username'] . '</div>';
                    echo '<div class="last-message">See Chats...</div>';
                    echo '</div>';
                    echo '</div>';
                }
            } else {
                echo 'Error: ' . mysqli_error($conn);
            }
            ?>
        </div>
    </div>
    <div class="message-box-container">
        <div id="chat-with" class="chat-header message message-grey">Chat with undefined</div>
        <div class="message-box" id="message-box"></div>
        <div class="send-message">
            <input type="text" id="message-input" placeholder="Send a Message">
            <button onclick="sendMessage()"><i class="fa fa-paper-plane"></i></button>
        </div>
    </div>
</div>
<script>
let selectedUserId = null;

async function loadMessages(userId, username) {
    selectedUserId = userId;
    document.getElementById('chat-with').textContent = `Chat with ${username}`;
    try {
        const response = await fetch(`fetch_messages_admin.php?user_id=${userId}`);
        const data = await response.json();
        console.log('Fetched Data:', data); // Debugging line
        const messageBox = document.getElementById('message-box');
        messageBox.innerHTML = '';
        data.messages.forEach(message => {
            const messageWrapper = document.createElement('div');
            messageWrapper.classList.add('message-wrapper');
            if (message.user_id == 1) {
                messageWrapper.classList.add('message-wrapper-right');
                messageWrapper.classList.add('admin-message');
            } else {
                messageWrapper.classList.add('message-wrapper-left');
                messageWrapper.classList.add('user-message');
            }
            const timestampElement = document.createElement('div');
            timestampElement.classList.add('timestamp');
            timestampElement.textContent = new Date(message.created_at).toLocaleString();
            const messageElement = document.createElement('div');
            messageElement.classList.add('message');
            if (message.file) {
                const fileElement = document.createElement('a');
                fileElement.href = message.file;
                fileElement.target = '_blank';
                const fileIcon = document.createElement('img');
                fileIcon.src = message.file;
                fileIcon.style.maxWidth = "100px";
                fileElement.appendChild(fileIcon);
                messageElement.appendChild(fileElement);
            } else {
                messageElement.textContent = message.message;
                messageElement.classList.add(message.user_id == 1 ? 'message-blue' : 'message-grey');
            }
            messageWrapper.appendChild(timestampElement);
            messageWrapper.appendChild(messageElement);
            messageBox.appendChild(messageWrapper);
        });
        messageBox.scrollTop = messageBox.scrollHeight;
    } catch (error) {
        console.error('Error:', error);
    }
}

async function sendMessage() {
    const input = document.getElementById('message-input');
    const message = input.value;
    if (message.trim() === '') return; // Don't send an empty message
    const formData = new FormData();
    formData.append('message', message);
    formData.append('user_id', selectedUserId || 'null'); // Pass 'null' if no user is selected

    try {
        const response = await fetch('send_message_admin.php', { method: 'POST', body: formData });
        const result = await response.json();

        if (result.success) {
            const messageBox = document.getElementById('message-box');
            const messageWrapper = document.createElement('div');
            messageWrapper.classList.add('message-wrapper', 'message-wrapper-right'); // Admin messages on the right
            const timestampElement = document.createElement('div');
            timestampElement.classList.add('timestamp');
            timestampElement.textContent = new Date().toLocaleString();
            const messageElement = document.createElement('div');
            messageElement.classList.add('message', 'message-blue');
            messageElement.textContent = message;
            messageWrapper.appendChild(timestampElement);
            messageWrapper.appendChild(messageElement);
            messageBox.appendChild(messageWrapper);
            input.value = '';
            messageBox.scrollTop = messageBox.scrollHeight;
        } else {
            console.error('Error:', result.error);
        }
    } catch (error) {
        console.error('Error:', error);
    }
}

document.getElementById('message-input').addEventListener('keypress', function(event) {
    if (event.key === 'Enter') {
        event.preventDefault();
        sendMessage();
    }
});

window.onload = () => {
    const firstUser = document.querySelector('.user-list-item');
    if (firstUser) {
        firstUser.click();
    }
};

setInterval(() => {
    if (selectedUserId) {
        loadMessages(selectedUserId);
    }
}, 5000);
</script>
<!-- =========== Scripts =========  -->
    <script src="assets/js/main.js"></script>

    <!-- ======= Charts JS ====== -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.1/dist/chart.min.js"></script>
    <script src="assets/js/chartsJS.js"></script>

    <!-- ====== ionicons ======= -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>

</html>
