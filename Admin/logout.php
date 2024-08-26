<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user'])) {
    // If not logged in, redirect to login page or any other appropriate page
    header("Location: ../LOGIN/login.php");
    exit();
}

// Logout logic
if (isset($_POST['logout'])) {
    // Destroy the session
    session_destroy();

    // Redirect to login page or any other appropriate page
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logout</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            background-color: #f4f4f4;
        }

        h2 {
            text-align: center;
            color: #333;
        }

        p {
            text-align: center;
            color: #666;
        }

        button {
            background-color: #007bff;
            color: #fff;
            padding: 10px;
            border: none;
            cursor: pointer;
        }

        #logoutModal {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            z-index: 1;
        }

        #logoutModal p {
            margin: 0 0 10px;
            color: #333;
        }

        #logoutModal button {
            margin-right: 10px;
        }
    </style>
</head>

<body>

    <h2>Logout</h2>

    <p>Are you sure you want to logout?</p>

    <button id="openModalBtn">Logout</button>

    <!-- Modal -->
    <div id="logoutModal">
        <p>Are you sure you want to logout?</p>
        <button onclick="confirmLogout()">Yes</button>
        <button onclick="closeModal()">No</button>
    </div>

    <script>
        function openModal() {
            document.getElementById('logoutModal').style.display = 'block';
        }

        function closeModal() {
            document.getElementById('logoutModal').style.display = 'none';
        }

        function confirmLogout() {
            // Handle logout logic here
            document.getElementById("logoutForm").submit();
        }

        // Trigger modal on button click
        document.getElementById('openModalBtn').addEventListener('click', openModal);
    </script>

    <form id="logoutForm" method="post" action="">
        <!-- Your form content here -->
        <input type="hidden" name="logout" value="1">
    </form>

</body>

</html>
