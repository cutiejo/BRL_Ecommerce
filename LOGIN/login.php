<?php
session_start();
include "../connections.php";

// Function to validate user credentials
function validateUser($useremail, $password, $role)
{
    global $conn;

    if ($conn === null) {
        die("Database connection is null.");
    }

    $query = "SELECT * FROM users WHERE useremail = ? AND role = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $useremail, $role);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            // Return user information if valid
            return $user;
        }
    }
    return false;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $useremail = $_POST["useremail"];
    $password = $_POST["password"];
    $role = $_POST["role"];

    $user = validateUser($useremail, $password, $role);
    if ($user) {
        // Store user information in session
        $_SESSION["user_id"] = $user['user_id'];
        $_SESSION["useremail"] = $useremail;

        // Redirect to the respective dashboard
        if ($role === "admin") {
            header("Location: ../Admin/dashboard.php");
            exit();
        } elseif ($role === "cashier") {
            header("Location: ../Cashier/dashboard.php");
            exit();
        } elseif ($role === "user") {
            header("Location: ../Userpage/index.php");
            exit();
        }
    } else {
        $error_message = "Invalid credentials. Please try again.";
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
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

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
                    <!-- For User Login -->
                    <form action="" method="post" autocomplete="off" class="sign-in-form">
                        <input type="hidden" name="role" value="user">
                        <div class="logo">
                            <img src="./img/logo_brl.png" alt="BRL Trading" />
                            <h4></h4>
                        </div>
                        <div class="heading">
                            <h2>Welcome</h2>
                            <h6>Login as User</h6>
                            <a href="#" class="toggle">Admin/Cashier</a>
                        </div>

                        <div class="actual-form">
                            <div class="input-wrap">
                                <input type="text" minlength="4" class="input-field" name="useremail" autocomplete="off" required />
                                <label>User Email</label>
                            </div>
                            <div class="input-wrap">
                                <input type="password" minlength="4" class="input-field" name="password" id="password" autocomplete="off" required />
                                <label>Password</label>
                                <span class="toggle-password" onclick="togglePasswordVisibility()"><i class="material-icons">visibility</i></span>
                            </div>
                            <div class="error-message"><?php echo isset($error_message) ? $error_message : ''; ?></div>
                            <a href="#" class="forgot-password" onclick="showForgotPassword()">Forgot Password?</a>
                            <input type="submit" value="LOGIN" class="sign-btn" />

                            <div class="signup-link">
                                <p style="font-size: 13px;">Don't have an account? <a href="./user_register.php" style="font-size: 13px;">Create an account</a></p>
                            </div>
                        </div>
                    </form>

                    <!-- For Admin and Cashier Login -->
                    <form action="" method="post" autocomplete="off" class="sign-up-form">
                        <div class="logo">
                            <img src="./img/logo_brl.png" alt="BRL Trading" />
                            <h4></h4>
                        </div>
                        <div class="heading">
                            <h2>Welcome</h2>
                            <h6>Login as Admin or Cashier</h6>
                            <a href="#" class="toggle">User</a>
                        </div>

                        <div class="actual-form">
                            <div class="input-wrap">
                                <input type="text" minlength="4" class="input-field" name="useremail" autocomplete="off" required />
                                <label>User Email</label>
                            </div>
                            <div class="input-wrap">
                                <input type="password" minlength="4" class="input-field" name="password" id="password2" autocomplete="off" required />
                                <label>Password</label>
                                <span class="toggle-password" onclick="togglePasswordVisibility2()"><i class="material-icons">visibility</i></span>
                            </div>
                            <div class="input-wrap">
                                <select class="input-field" name="role" required>
                                    <option value="" disabled selected>Choose your role</option>
                                    <option value="admin">Admin</option>
                                    <option value="cashier">Cashier</option>
                                </select>
                            </div>
                            <div class="error-message"><?php echo isset($error_message) ? $error_message : ''; ?></div>
                            <a href="#" class="forgot-password" onclick="showForgotPassword()">Forgot Password?</a>
                            <input type="submit" value="LOGIN" class="sign-btn" />
                        </div>
                    </form>

                    <!-- Forgot Password Form -->
                    <form action="forgot_password.php" method="post" autocomplete="off" class="forgot-password-form" style="display: none;">
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
                            <div class="input-wrap">
                                <input type="email" class="input-field" name="useremail" autocomplete="off" required />
                                <label>User Email</label>
                            </div>
                            <input type="submit" name="forgot_password" value="Send Reset Instructions" class="sign-btn" />
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
            var icon = document.querySelector(".toggle-password i");
            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                icon.textContent = "visibility_off";
            } else {
                passwordInput.type = "password";
                icon.textContent = "visibility";
            }
        }

        function togglePasswordVisibility2() {
            var passwordInput = document.getElementById("password2");
            var icon = document.querySelector(".toggle-password i");
            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                icon.textContent = "visibility_off";
            } else {
                passwordInput.type = "password";
                icon.textContent = "visibility";
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

            // AJAX for password validation
            $("#password").on("input", function () {
                var useremail = $("input[name='useremail']").val();
                var password = $(this).val();
                var role = $("input[name='role']").val();

                $.ajax({
                    type: "POST",
                    url: "check_password.php",
                    data: {
                        useremail: useremail,
                        password: password,
                        role: role,
                    },
                    success: function (response) {
                        if (response === "false") {
                            // Password is not valid, show an error or take appropriate action
                            // For now, let's log a message in the console
                            console.log("Invalid password");
                        }
                    },
                });
            });
        });
    </script>
    <script src="app.js"></script>
</body>

</html>
