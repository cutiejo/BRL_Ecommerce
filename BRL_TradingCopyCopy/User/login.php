<?php
session_start();
include "../connections.php";

// Function to validate user credentials
function validateUser($useremail, $password, $role)
{
    global $conn; // Change variable name to $conn

    if ($conn === null) {
        die("Database connection is null.");
    }

    $query = "SELECT * FROM users WHERE useremail = ? AND password = ? AND role = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sss", $useremail, $password, $role);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        // Valid user
        return true;
    } else {
        // Invalid user
        return false;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["forgot_password"])) {
        // Get the email address entered by the user
        $resetEmail = $_POST["reset_email"];
        
        // Check if the email exists in the database
        $query = "SELECT * FROM users WHERE useremail = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $resetEmail);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows === 1) {
            // Email exists, update the password for the user
            $newPassword = $_POST["new_password"];
            
            // Update the user's password in the database
            $query = "UPDATE users SET password = ? WHERE useremail = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("ss", $newPassword, $resetEmail);
            $stmt->execute();
            
            // Redirect or provide feedback to the user
            header("Location: login.php"); // Redirect to login page after resetting password
            exit();
        } else {
            // Email does not exist, provide feedback to the user
            $error_message = "Email address not found. Please enter a valid email address.";
        }
    } else {
        $useremail = $_POST["useremail"];
        $password = $_POST["password"];
        $role = $_POST["role"];

        if (validateUser($useremail, $password, $role)) {
            // Successful login, redirect to the respective dashboard
            if ($role === "admin") {
                $_SESSION["useremail"] = $useremail; // Store user email in session if needed
                header("Location: ../Admin/dashboard.php");
                exit();
            } elseif ($role === "cashier") {
                $_SESSION["useremail"] = $useremail; // Store user email in session if needed
                header("Location: ../Cashier/dashboard.php");
                exit();
            }
        } else {
            $error_message = "Invalid credentials. Please try again.";
        }
    }
}

// Check the status of the $conn object
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
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
    <!-- Boxicons -->
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://unpkg.com/ionicons@5.6.3/dist/css/ionicons.min.css" />

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <style>
        .toggle-password {
            cursor: pointer;
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #777;
            font-size: 20px;
        }

        .error-message {
            color: #ff0000;
            text-align: center;
        }
    </style>
</head>

<body>
    <main>
        <div class="box">
            <div class="inner-box">
                <div class="forms-wrap">
                    <!-- For Admin/Cashier Login -->
                    <form action="" method="post" autocomplete="off" class="sign-in-form">
                        <input type="hidden" name="role" value="cashier">
                        <div class="logo">
                            <img src="./img/logo_brl.png" alt="easyclass" />
                            <h4></h4>
                        </div>
                        <div class="heading">
                            <h2>Welcome</h2>
                            <h6>Login as Admin/Cashier</h6>
                            <a href="#" class="toggle">Back to User page</a>
                        </div>

                        <div class="actual-form">
                            <div class="input-wrap">
                                <input type="text" minlength="4" class="input-field" name="useremail" autocomplete="off" required />
                                <label>User Email</label>
                            </div>
                            <div class="input-wrap">
                                <input type="password" minlength="4" class="input-field" name="password" id="password" autocomplete="off" required />
                                <label>Password</label>
                                <span class="toggle-password" onclick="togglePasswordVisibility()"><i class="ion-eye"></i></span>
                            </div>
                            <div class="error-message"><?php echo isset($error_message) ? $error_message : ''; ?></div>
                            <a href="#" class="forgot-password" onclick="showForgotPassword()">Forgot Password?</a>
                            <input type="submit" value="LOGIN" class="sign-btn" />
                        </div>
                    </form>

                    <!-- For User Login -->
                    <form action="" method="post" autocomplete="off" class="sign-up-form">
                        <input type="hidden" name="role" value="admin">
                        <div class="logo">
                            <img src="./img/logo_brl.png" alt="BRL Trading" />
                            <h4></h4>
                        </div>
                        <div class="heading">
                            <h2>Welcome</h2>
                            <h6>Login as User</h6>
                            <a href="#" class="toggle">Back to Admin page</a>
                        </div>

                        <div class="actual-form">
                            <div class="input-wrap">
                                <input type="text" minlength="4" class="input-field" name="useremail" autocomplete="off" required />
                                <label>User Email</label>
                            </div>
                            <div class="input-wrap">
                                <input type="password" minlength="4" class="input-field" name="password" autocomplete="off" required />
                                <label>Password</label>
                                <span class="toggle-password" onclick="togglePasswordVisibility()"><i class="ion-eye"></i></span>
                            </div>
                            <div class="error-message"><?php echo isset($error_message) ? $error_message : ''; ?></div>
                            <a href="#" class="forgot-password" onclick="showForgotPassword()">Forgot Password?</a>
                            <input type="submit" value="LOGIN" class="sign-btn" />
                            <div class="signup-link">
                                <p style="font-size: 13px;">Don't have an account? <a href="../User/user_register.php" style="font-size: 13px;">Create an account</a></p>
                            </div>
                        </div>
                    </form>

                    <!-- Forgot Password Form -->
                    <form action="" method="post" autocomplete="off" class="forgot-password-form" style="display: none;">
                        <div class="logo">
                            <img src="./img/logo_brl.png" alt="BRL Trading" />
                            <h4></h4>
                        </div>
                        <div class="heading">
                            <h2>Forgot Password</h2>
                            <h6>Enter your email to reset your password</h6>
                            <a href="#" class="toggle" onclick="showForgotPassword()">Back to Login</a>
                        </div>

                        <div class="actual-form">
                            <!-- Input field for user email -->
                            <div class="input-wrap">
                                <input type="email" class="input-field" name="reset_email" autocomplete="off" required />
                                <label>Email Address</label>
                            </div>

                            <!-- New input field for entering a new password -->
                            <div class="input-wrap">
                                <input type="password" minlength="4" class="input-field" name="new_password" autocomplete="off" required />
                                <label>New Password</label>
                            </div>

                            <!-- Submit button -->
                            <input type="submit" name="forgot_password" value="Reset Password" class="sign-btn" />
                        </div>
                    </form>

                </div>

                <!-- Your carousel content -->
                <div class="carousel">
                    <div class="images-wrapper">
                        <img src="./img/pic1.png" class="image img-1 show" alt="" />
                        <img src="./img/pic2.png" class="image img-2" alt="" />
                        <img src="./img/pic1.png" class="image img-3" alt="" />
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
        </div>
    </main>

    <script>
        function togglePasswordVisibility() {
            var passwordInput = document.getElementById("password");
            if (passwordInput.type === "password") {
                passwordInput.type = "text";
            } else {
                passwordInput.type = "password";
            }
        }

        function showForgotPassword() {
            $(".sign-in-form, .sign-up-form").toggle();
            $(".forgot-password-form").toggle();
        }

        $(document).ready(function () {
            $(".toggle-password").click(function () {
                togglePasswordVisibility();
            });
        });
    </script>
    <script src="app.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</body>
</html>
