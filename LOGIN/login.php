<?php
session_start();
include "../connections.php";

// Function to validate user credentials
function validateUser($useremail, $password, $role) {
    global $conn;
    $query = "SELECT password FROM users WHERE useremail = ? AND role = ?";
    $stmt = $conn->prepare($query);
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
    if (isset($_POST["forgot_password"])) {
        $resetEmail = $_POST["reset_email"];
        $newPassword = password_hash($_POST["new_password"], PASSWORD_BCRYPT);
        $query = "UPDATE user SET password = ? WHERE useremail = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ss", $newPassword, $resetEmail);
        $stmt->execute();
        header("Location: login.php");
        exit();
    } else {
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
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>LOGIN</title>
    <link rel="stylesheet" href="style.css" />
</head>
<body>
    <main>
        <div class="box">
            <div class="inner-box">
                <div class="forms-wrap">
                    <!-- For Admin and Cashier Login -->
                    <form action="login.php" method="post" autocomplete="off" class="sign-in-form" id="admin-cashier-login">
                        <div class="logo">
                            <img src="./img/logo_brl.png" alt="BRL Trading" />
                        </div>
                        <div class="heading">
                            <h2>Welcome</h2>
                            <h6>Login as Admin or Cashier</h6>
                            <a href="#" class="toggle" onclick="showForm('user')">User</a>
                        </div>
                        <div class="actual-form">
                            <div class="input-wrap">
                                <input
                                    type="text"
                                    class="input-field"
                                    name="useremail"
                                    autocomplete="off"
                                    placeholder="User Email"
                                    required
                                />
                                <label>User Email</label>
                            </div>
                            <div class="input-wrap">
                                <input
                                    type="password"
                                    class="input-field"
                                    name="password"
                                    id="admin-cashier-password"
                                    autocomplete="off"
                                    placeholder="Password"
                                    required
                                />
                                <label>Password</label>
                            </div>
                            <div class="input-wrap">
                                <select class="input-field" name="role" required>
                                    <option value="">Select Role</option>
                                    <option value="admin">Admin</option>
                                    <option value="cashier">Cashier</option>
                                </select>
                                <label>Role</label>
                            </div>
                            <div class="error-message"><?php echo $error_message; ?></div>
                            <a href="#" class="forgot-password" onclick="showForgotPassword()">Forgot Password?</a>
                            <input type="submit" value="LOGIN" class="sign-btn" />
                        </div>
                    </form>

                    <!-- For User Login -->
                    <form action="login.php" method="post" autocomplete="off" class="sign-up-form" id="user-login">
                        <input type="hidden" name="role" value="user">
                        <div class="logo">
                            <img src="./img/logo_brl.png" alt="BRL Trading" />
                        </div>
                        <div class="heading">
                            <h2>Welcome</h2>
                            <h6>Login as User</h6>
                            <a href="#" class="toggle" onclick="showForm('admin-cashier')">Admin/Cashier</a>
                        </div>
                        <div class="actual-form">
                            <div class="input-wrap">
                                <input
                                    type="text"
                                    class="input-field"
                                    name="useremail"
                                    autocomplete="off"
                                    placeholder="User Email"
                                    required
                                />
                                <label>User Email</label>
                            </div>
                            <div class="input-wrap">
                                <input
                                    type="password"
                                    class="input-field"
                                    name="password"
                                    id="user-password"
                                    autocomplete="off"
                                    placeholder="Password"
                                    required
                                />
                                <label>Password</label>
                            </div>
                            <div class="error-message"><?php echo $error_message; ?></div>
                            <input type="submit" value="LOGIN" class="sign-btn" />
                        </div>
                    </form>

                    <!-- Forgot Password Form -->
                    <form action="login.php" method="post" autocomplete="off" class="forgot-password-form" style="display: none;">
                        <div class="logo">
                            <img src="./img/logo_brl.png" alt="BRL Trading" />
                        </div>
                        <div class="heading">
                            <h2>Forgot Password</h2>
                            <h6>Enter your email to reset your password</h6>
                            <a href="#" class="toggle" onclick="showForm('admin-cashier')">Back to Login</a>
                        </div>

                        <div class="actual-form">
                            <div class="input-wrap">
                                <input
                                    type="email"
                                    class="input-field"
                                    name="reset_email"
                                    autocomplete="off"
                                    placeholder="Email Address"
                                    required
                                />
                                <label>Email Address</label>
                            </div>

                            <div class="input-wrap">
                                <input
                                    type="password"
                                    class="input-field"
                                    name="new_password"
                                    autocomplete="off"
                                    placeholder="New Password"
                                    required
                                />
                                <label>New Password</label>
                            </div>

                            <input type="submit" name="forgot_password" value="Reset Password" class="sign-btn" />
                        </div>
                    </form>
                </div>
            </div>
            <div class="carousel">
                <div class="images-wrapper">
                    <img src="./img/pic1.png" class="image img-1 show" alt="" />
                    <img src="./img/pic2.png" class="image img-2" alt="" />
                    <img src="./img/pic3.png" class="image img-3" alt="" />
                </div>
                <div class="text-slider">
                    <div class="text-wrap">
                        <div class="text-group">
                            <h2></h2>
                            <h2></h2>
                            <h2></h2>
                        </div>
                    </div>
                    <div class="bullets">
                        <span class="active" data-value="1"></span>
                        <span data-value="2"></span>
                        <span data-value="3"></span>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
</html>


