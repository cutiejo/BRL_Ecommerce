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
    <title>Cashier</title>
    <!-- ======= Styles ====== -->
    <link rel="stylesheet" href="./assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        .header {
            background-color: #00BFAE;
            color: white;
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header .logo {
            display: flex;
            align-items: center;
        }

        .header .logo img {
            height: 40px;
            margin-right: 10px;
        }

        .header .search-bar {
            flex: 1;
            margin: 0 20px;
        }

        .header .search-bar input {
            width: 100%;
            padding: 5px;
            border: none;
            border-radius: 5px;
        }

        .header .icons {
            display: flex;
            gap: 20px;
        }

        .header .icons i {
            font-size: 24px;
        }

        .message-container {
            padding: 20px;
            display: flex;
            flex-direction: column;
            height: calc(100vh - 80px); /* Adjust based on header height */
        }

        .message-header {
            font-size: 24px;
            margin-bottom: 10px;
        }

        .message-box {
            max-height: 70vh;
            overflow-y: auto;
            background-color: white; /* Set background to white */
            padding: 20px;
            border-radius: 10px;
        }

        .message-wrapper-right {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            margin-bottom: 10px;
        }

        .message-wrapper-left {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            margin-bottom: 10px;
        }

        .timestamp {
            font-size: 0.8em;
            color: #888;
            margin-bottom: 2px; /* Add space between timestamp and message */
        }

        .message {
            padding: 10px;
            border-radius: 20px;
            display: inline-block; /* Ensure the message background only covers the content */
            width: fit-content; /* Make the width of the message depend on its content */
            max-width: 80%; /* Ensure the messages don't take up the full width */
            word-wrap: break-word; /* Ensure long words break correctly */
            white-space: pre-wrap; /* Preserve white space and line breaks */
        }

        .message-blue {
            background-color: #007bff; /* Blue background for all messages */
            color: white; /* Ensure text is white */
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
            margin-right: 10px; /* Adjust margin to match button */
            box-sizing: border-box; /* Include padding in width calculation */
        }

        .send-message button {
            background-color: #007bff;
            border: none;
            color: white;
            padding: 10px;
            border-radius: 50%;
            cursor: pointer;
            flex-shrink: 0; /* Prevent button from shrinking */
        }
    </style>
</head>

<body>
    <!-- =============== Navigation ================ -->
    <div class="container">
        <div class="navigation">
            <ul>
                <li>
                    <a href="#">
                        <span class="icon">
                            <img src="ASSETS/imgs/logo_brl.png" width="100px" height="60px" alt="logo" />
                        </span>
                        <span class="title"></span>
                    </a>
                </li>
                <li>
                    <a href="dashboard.php">
                        <span class="icon">
                            <ion-icon name="home-outline"></ion-icon>
                        </span>
                        <span class="title">Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="product.php">
                        <span class="icon">
                            <ion-icon name="folder-open-outline"></ion-icon>
                        </span>
                        <span class="title">Inventory List</span>
                    </a>
                </li>
                <li>
                    <a href="category.php">
                        <span class="icon">
                            <ion-icon name="options-outline"></ion-icon>
                        </span>
                        <span class="title">Category</span>
                    </a>
                </li>
                <li>
                    <a href="stock.php">
                        <span class="icon">
                            <ion-icon name="pricetags-outline"></ion-icon>
                        </span>
                        <span class="title">Stock</span>
                    </a>
                </li>
                <li>
                    <a href="purchase.php">
                        <span class="icon">
                            <ion-icon name="list-outline"></ion-icon>
                        </span>
                        <span class="title">Purchase Order List</span>
                    </a>
                </li>
                <li>
                    <a href="sales.php">
                        <span class="icon">
                            <ion-icon name="analytics-outline"></ion-icon>
                        </span>
                        <span class="title">Sales</span>
                    </a>
                </li>

                <li>
                    <a href="message.php">
                        <span class="icon">
                            <ion-icon name="people-outline"></ion-icon>
                        </span>
                        <span class="title">Message</span>
                    </a>
                </li>

                <li>
                    <a href="reports.php">
                        <span class="icon">
                            <ion-icon name="document-text-outline"></ion-icon>
                        </span>
                        <span class="title">Reports</span>
                    </a>
                </li>
                
           <!--     <li>
                    <a href="user.php">
                        <span class="icon">
                            <ion-icon name="people-outline"></ion-icon>
                        </span>
                        <span class="title">User</span>
                    </a>
                </li> -->
                <li>
                    <a href="logout.php">
                        <span class="icon">
                            <ion-icon name="log-out-outline"></ion-icon>
                        </span>
                        <span class="title">Sign Out</span>
                    </a>
                </li>
            </ul>
        </div>

        <!-- ========================= Main CONTENT OF MESSAGE ==================== -->
        <div class="main">
            <div class="topbar">
                <div class="toggle">
                    <ion-icon name="menu-outline"></ion-icon>
                </div>
                <div class="title" onclick="alert('Title Clicked!')">
                    <ion-icon name="basket-outline"></ion-icon>
                    <h4>POS with Inventory</h4>
                </div>
                <div class="user-dropdown">
                    <div class="user">
                        <img src="assets/imgs/customer01.png" alt="">
                    </div>
                    <div class="dropdown-content">
                        <a href="#" onclick="openModal('profileModal')">Profile</a>
                        <a href="#" onclick="openModal('settingsModal')">Settings</a>
                        <a href="#" onclick="openModal('logoutModal')" class="logout">Logout</a>
                    </div>
                </div>
            </div>

            <!-- Profile Modal -->
            <div id="profileModal" class="modal">
                <div class="modal-content">
                    <span class="close" onclick="closeModal('profileModal')">&times;</span>
                    <h2>Profile</h2>
                    <div class="profile-info">
                        <?php
                        // Start the session
                        session_start();
                        // Check if the user is logged in
                        if (isset($_SESSION['user_id'])) {
                            // Include your database connection file
                            include './connections.php';
                            // Fetch user details from the database
                            $userId = $_SESSION['user_id'];
                            $query = "SELECT username, email, user_type FROM users WHERE id = $userId";
                            $result = mysqli_query($conn, $query);
                            if ($result && mysqli_num_rows($result) > 0) {
                                $userData = mysqli_fetch_assoc($result);
                                $greetingType = ucfirst($userData['user_type']); // Capitalize the user type
                                echo "<p>Hello, {$greetingType} {$userData['username']}!</p>";
                                echo "<p>Email: {$userData['email']}</p>";
                            } else {
                                echo "<p>Error fetching user information.</p>";
                            }
                        } else {
                            echo "<p>User not logged in.</p>";
                        }
                        ?>
                    </div>
                    <!-- Edit Account Form -->
                    <form id="editAccountForm" action="edit_account.php" method="POST">
                        <div class="form-group">
                            <label for="editUsername">New Username:</label>
                            <input type="text" id="editUsername" name="editUsername" placeholder="Enter new username">
                        </div>
                        <div class="form-group">
                            <label for="editPassword">New Password:</label>
                            <input type="password" id="editPassword" name="editPassword" placeholder="Enter new password">
                        </div>
                        <!-- Add more fields as needed for editing account details -->
                        <button type="submit" name="editAccount">Save Changes</button>
                    </form>
                </div>
            </div>

            <!-- Settings Modal -->
            <div id="settingsModal" class="modal">
                <div class="modal-content">
                    <span class="close" onclick="closeModal('settingsModal')">&times;</span>
                    <h2>Settings</h2>
                    <!-- General Settings -->
                    <div class="settings-section">
                        <h3>General Settings</h3>
                        <form id="generalSettingsForm" action="update_settings.php" method="POST">
                            <div class="form-group">
                                <label for="siteName">Site Name:</label>
                                <input type="text" id="siteName" name="siteName" placeholder="Enter site name">
                            </div>
                            <!-- Add more general settings as needed -->
                            <button type="submit" name="updateGeneralSettings">Save Changes</button>
                        </form>
                    </div>
                    <!-- Security Settings -->
                    <div class="settings-section">
                        <h3>Security Settings</h3>
                        <form id="securitySettingsForm" action="update_settings.php" method="POST">
                            <div class="form-group">
                                <label for="changePassword">Change Password:</label>
                                <input type="password" id="changePassword" name="changePassword" placeholder="Enter new password">
                            </div>
                            <!-- Add more security settings as needed -->
                            <button type="submit" name="updateSecuritySettings">Save Changes</button>
                        </form>
                    </div>
                    <!-- Other Settings Sections -->
                    <!-- Add more sections and settings forms as needed -->
                </div>
            </div>

            <!-- Logout Modal -->
            <div id="logoutModal" class="modal">
                <div class="modal-content">
                    <span class="close" onclick="closeModal('logoutModal')">&times;</span>
                    <h2 class="modal-title">Logout</h2>
                    <p class="modal-message">Are you sure you want to log out?</p>
                    <div class="logout-actions">
                        <!-- Call the logout function when the "Logout" button is clicked -->
                        <button class="logout-btn" onclick="logout()">Logout</button>
                        <!-- Simply close the modal when the "Cancel" button is clicked -->
                        <button class="cancel-btn" onclick="closeModal('logoutModal')">Cancel</button>
                    </div>
                </div>
            </div>

            <script>
                // JavaScript function to logout
                function logout() {
                    // You can add any additional logout logic here, such as redirecting to a logout script
                    // Redirect to the login page after successful logout
                    window.location.href = './LOGIN/login.php';
                }

                // Function to close the modal
                function closeModal(modalId) {
                    var modal = document.getElementById(modalId);
                    modal.style.display = "none";
                }
            </script>

            <!-- Messaging Section ------------------------------------------------------------------------------------------------------------------------------>

            <div class="message-container">
                <div class="message-header">Message</div>
                <div class="message-box" id="message-box"></div>
                <div class="send-message">
                    <input type="text" id="message-input" placeholder="Send a Message">
                    <button onclick="sendMessage()">Send</button>
                </div>
            </div>
        </div>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>

        <!-- Messaging Script -->
        <script>
            async function loadMessages() {
                try {
                    const response = await fetch('fetch_messeges.php');
                    const messages = await response.json();
                    const messageBox = document.getElementById('message-box');
                    messageBox.innerHTML = '';
                    messages.forEach(message => {
                        const messageWrapper = document.createElement('div');
                        messageWrapper.classList.add('message-wrapper');
                        if (message.system === 'A') {
                            messageWrapper.classList.add('message-wrapper-right');
                        } else {
                            messageWrapper.classList.add('message-wrapper-left');
                        }

                        const timestampElement = document.createElement('div');
                        timestampElement.classList.add('timestamp');
                        timestampElement.textContent = message.created_at;

                        const messageElement = document.createElement('div');
                        messageElement.classList.add('message', 'message-blue'); // Ensure blue background
                        messageElement.textContent = message.text;

                        messageWrapper.appendChild(timestampElement);
                        messageWrapper.appendChild(messageElement);
                        messageBox.appendChild(messageWrapper);
                    });
                    messageBox.scrollTop = messageBox.scrollHeight; // Scroll to bottom after loading messages
                } catch (error) {
                    console.error('Error:', error);
                }
            }

            async function sendMessage() {
                const input = document.getElementById('message-input');
                const message = input.value;
                if (message.trim() === '') return;

                const formData = new FormData();
                formData.append('text', message);
                formData.append('system', 'A'); // Specify the system sending the message (A for System A)

                try {
                    const response = await fetch('send_message.php', {
                        method: 'POST',
                        body: formData
                    });

                    const result = await response.json();
                    console.log(result);  // Add this line to check the response

                    if (result.error) {
                        console.error('Error:', result.error);
                    } else {
                        const messageBox = document.getElementById('message-box');
                        const messageWrapper = document.createElement('div');
                        messageWrapper.classList.add('message-wrapper', 'message-wrapper-right'); // Apply the right alignment for System A messages

                        const timestampElement = document.createElement('div');
                        timestampElement.classList.add('timestamp');
                        timestampElement.textContent = result.created_at;

                        const messageElement = document.createElement('div');
                        messageElement.classList.add('message', 'message-blue'); // Ensure blue background
                        messageElement.textContent = result.text;

                        messageWrapper.appendChild(timestampElement);
                        messageWrapper.appendChild(messageElement);
                        messageBox.appendChild(messageWrapper);

                        input.value = '';
                        messageBox.scrollTop = messageBox.scrollHeight; // Scroll to bottom after sending a message
                    }
                } catch (error) {
                    console.error('Error:', error);
                }
            }

            // Add event listener for Enter key press
            document.getElementById('message-input').addEventListener('keypress', function (event) {
                if (event.key === 'Enter') {
                    event.preventDefault();
                    sendMessage();
                }
            });

            window.onload = loadMessages;
            setInterval(loadMessages, 5000); // Refresh messages every 5 seconds
        </script>

        <!-- =========== Scripts =========  -->
        <script src="assets/js/main.js"></script>
        <!-- Include jsPDF library -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.7.6/jspdf.plugin.autotable.min.js"></script>
        <!-- Include XLSX library -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.3/xlsx.full.min.js"></script>
        <!-- Include html2pdf library -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
        <!-- ======= Charts JS ====== -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.1/dist/chart.min.js"></script>
        <script src="assets/js/chartsJS.js"></script>
        <!-- ====== ionicons ======= -->
        <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
        <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    </div>
</body>

</html>
