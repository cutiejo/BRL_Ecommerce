<?php
session_start();
include "../connections.php";

// Function to validate user credentials
function validateUser($useremail, $password, $role) {
    global $conn;
    $query = "SELECT password FROM users WHERE useremail = ? AND role = ?";
    $stmt = $conn->prepare($query);
    if ($stmt === false) {
        die('Prepare failed: ' . htmlspecialchars($conn->error));
    }
    $stmt->bind_param("ss", $useremail, $role);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        return password_verify($password, $row['password']);
    } else {
        return false;
    }
}

$error_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $useremail = $_POST["useremail"];
    $password = $_POST["password"];
    $role = $_POST["role"];
    if (!empty($useremail) && !empty($password) && !empty($role)) {
        if (validateUser($useremail, $password, $role)) {
            $_SESSION["useremail"] = $useremail;
            if ($role === "admin") {
                header("Location: ../Admin/dashboard.php");
            } elseif ($role === "cashier") {
                header("Location: ../Cashier/dashboard.php");
            } elseif ($role === "user") {
                header("Location: ../Userpage/index.php");
            }
            exit();
        } else {
            $error_message = "Invalid credentials. Please try again.";
        }
    } else {
        $error_message = "All fields are required.";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container" id="container">
        <div class="form-container sign-in-container">
            <form action="login.php" method="post" autocomplete="off">
                <h1>Admin/Cashier Login</h1>
                <input type="text" name="useremail" placeholder="Email" required>
                <input type="password" name="password" placeholder="Password" required>
                <select name="role" required>
                    <option value="">Select Role</option>
                    <option value="admin">Admin</option>
                    <option value="cashier">Cashier</option>
                </select>
                <button type="submit">Login</button>
                <p class="toggle" id="user-link">Login as User</p>
                <div class="error-message"><?php echo isset($error_message) ? $error_message : ''; ?></div>
            </form>
        </div>
        <div class="form-container sign-up-container">
            <form action="login.php" method="post" autocomplete="off">
                <input type="hidden" name="role" value="user">
                <h1>User Login</h1>
                <input type="text" name="useremail" placeholder="Email" required>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit">Login</button>
                <p class="toggle" id="admin-link">Login as Admin/Cashier</p>
                <div class="error-message"><?php echo isset($error_message) ? $error_message : ''; ?></div>
            </form>
        </div>
        <div class="carousel">
            <div class="images-wrapper">
                <img src="img/pic1.png" class="image img-1 show" alt="">
                <img src="img/pic2.png" class="image img-2" alt="">
                <img src="img/pic3.png" class="image img-3" alt="">
            </div>
            <div class="bullets">
                <span class="active" data-value="1"></span>
                <span data-value="2"></span>
                <span data-value="3"></span>
            </div>
        </div>
    </div>
    <script src="app.js"></script>
</body>
</html>
