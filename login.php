<?php
session_start();
include "../connections.php";

// Function to validate user credentials
function validateUser($useremail, $password, $role) {
    global $conn;
    $query = "SELECT * FROM user WHERE useremail = ? AND password = ? AND role = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sss", $useremail, $password, $role);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->num_rows === 1;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["forgot_password"])) {
        $resetEmail = $_POST["reset_email"];
        $newPassword = $_POST["new_password"];
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
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://unpkg.com/ionicons@5.6.3/dist/css/ionicons.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</head>

<body>
    <main>
        <div class="box">
            <div class="inner-box">
                <div class="forms-wrap">
                    <!-- For Admin and Cashier Login -->
                    <form action="" method="post" autocomplete="off" class="sign-in-form" id="admin-cashier-login" onsubmit="return checkRequiredFields();">
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
                                <span class="toggle-password" onclick="togglePasswordVisibility('admin-cashier-password')"><i class="fas fa-eye"></i></span>
                            </div>
                            <div class="input-wrap">
                                <select class="input-field" name="role" required>
                                    <option value="">Select Role</option>
                                    <option value="admin">Admin</option>
                                    <option value="cashier">Cashier</option>
                                </select>
                                <label>Role</label>
                            </div>
                            <div class="error-message"><?php echo isset($error_message) ? $error_message : ''; ?></div>
                            <a href="#" class="forgot-password" onclick="showForgotPassword()">Forgot Password?</a>
                            <input type="submit" value="LOGIN" class="sign-btn" />
                        </div>
                    </form>

                    <!-- For User Login -->
                    <form action="" method="post" autocomplete="off" class="sign-up-form" id="user-login" style="display: none;" onsubmit="return checkRequiredFields();">
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
                                <span class="toggle-password" onclick="togglePasswordVisibility('user-password')"><i class="fas fa-eye"></i></span>
                            </div>
                            <div class="error-message"><?php echo isset($error_message) ? $error_message : ''; ?></div>
                            <a href="#" class="forgot-password" onclick="showForgotPassword()">Forgot Password?</a>
                            <input type="submit" value="LOGIN" class="sign-btn" />
                        </div>
                    </form>

                    <!-- Forgot Password Form -->
                    <form action="" method="post" autocomplete="off" class="forgot-password-form" style="display: none;">
                        <div class="logo">
                            <img src="./img/logo_brl.png" alt="BRL Trading" />
                        </div>
                        <div class="heading">
                            <h2>Forgot Password</h2>
                            <h6>Enter your email to reset your password</h6>
                            <a href="#" class="toggle" onclick="showForm('admin-cashier')">Back to Login</a>
                        </div>

                        <div class="actual-form">
                            <!-- Input field for user email -->
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

                            <!-- New input field for entering a new password -->
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
        function togglePasswordVisibility(id) {
            var passwordInput = document.getElementById(id);
            var icon = document.querySelector(`#${id} + .toggle-password i`);
            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = "password";
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }

        function showForgotPassword() {
            $(".sign-in-form, .sign-up-form, .user-form").hide();
            $(".forgot-password-form").show();
        }

        function showForm(role) {
            if (role === 'admin-cashier') {
                $("#admin-cashier-login").show();
                $("#user-login").hide();
            } else if (role === 'user') {
                $("#admin-cashier-login").hide();
                $("#user-login").show();
            }
        }

        function checkRequiredFields() {
            var isValid = true;
            var fields = $("input[required], select[required]");
            fields.each(function() {
                if ($(this).val() === "") {
                    this.setCustomValidity("All fields are required.");
                    this.reportValidity();
                    isValid = false;
                } else {
                    this.setCustomValidity("");
                }
            });
            return isValid;
        }

        $(document).ready(function () {
            $("input, select").on("input change", function () {
                if ($(this).val().trim() !== "") {
                    $(this).addClass("active");
                    if ($(this).attr("type") === "password") {
                        $(this).siblings(".toggle-password").show(); // Show the eye icon for password fields
                    }
                } else {
                    $(this).removeClass("active");
                    if ($(this).attr("type") === "password") {
                        $(this).siblings(".toggle-password").hide(); // Hide the eye icon for password fields
                    }
                }
            });

            $(".toggle").click(function (e) {
                e.preventDefault();
                var role = $(this).text().toLowerCase();
                if(role === 'user') {
                    showForm('user');
                } else {
                    showForm('admin-cashier');
                }
            });

            $("form").on("submit", function() {
                var valid = checkRequiredFields();
                if (!valid) {
                    $(".input-field:invalid, select:invalid").first().focus();
                }
                return valid;
            });
        });
    </script>
    <script src="app.js"></script>
</body>
</html>
