<?php
// Include the database connection file
include '../connections.php';

// Initialize variables for error messages
$password_error = '';
$mobile_error = '';
$message = '';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $full_name = $_POST['full-name'];
    $gender = $_POST['gender'];
    $email = $_POST['email'];
    $birthday = $_POST['birthday'];
    $address = $_POST['address'];
    $password = $_POST['password'];
    $mobile_number = $_POST['mobile'];

    // Server-side password validation
    $password_pattern = "/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/";
    $mobile_pattern = "/^9\d{9}$/";
    if (!preg_match($password_pattern, $password)) {
        $password_error = "Password must be at least 8 characters long and include an uppercase letter, a lowercase letter, a number, and a special character.";
    } elseif (!preg_match($mobile_pattern, $mobile_number)) {
        $mobile_error = "Mobile number must start with 9 and be 10 digits long.";
    } else {
        // Hash the password for security
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Start transaction
        $conn->begin_transaction();

        try {
            // Insert into users table
            $query = "INSERT INTO users (username, useremail, password, role) VALUES (?, ?, ?, 'user')";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("sss", $full_name, $email, $hashed_password);
            $stmt->execute();

            // Get the inserted user's ID
            $user_id = $stmt->insert_id;

            // Insert into user_details table
            $query = "INSERT INTO user_details (user_id, full_name, gender, birthday, mobile_number, address) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("isssss", $user_id, $full_name, $gender, $birthday, $mobile_number, $address);
            $stmt->execute();

            // Commit transaction
            $conn->commit();

            // Redirect to login page after successful registration
            header("Location: ../LOGIN/login.php");
            exit(); // Make sure to call exit after redirection
        } catch (Exception $e) {
            // Rollback transaction in case of error
            $conn->rollback();
            $message = "Registration failed. Please try again.";
        }

        // Close the statement
        $stmt->close();
    }
    
    // Close the connection
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>

    <!-- Box Icons  -->
    <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
    <!-- Styles  -->
    <link rel="stylesheet" href="user_register.css">
    <link rel="icon" href="assets/img/logo_brl.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel/slick/slick.css"/>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel/slick/slick-theme.css"/>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&family=Montserrat:wght@400;700&display=swap">
    <style>
        .error-message {
            color: red;
            font-size: 14px;
        }
    </style>
</head>

<body>
    <!-- ============= Home Section =============== -->
    <br>
    <section class="home">
        <div class="form-container">
            <h2>Register Account</h2>
            <?php
            if (!empty($message)) {
                echo "<p class='error-message'>$message</p>";
            }
            ?>
            <form action="" method="post" onsubmit="return validateForm()">
                <div class="form-row">
                    <div class="form-group">
                        <label for="full-name">Full Name</label>
                        <input type="text" id="full-name" name="full-name" placeholder="Enter your full name" required>
                    </div>
                    <div class="form-group">
                        <label for="gender">Gender</label>
                        <select id="gender" name="gender" required>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" placeholder="Enter your email" required>
                    </div>
                    <div class="form-group">
                        <label for="birthday">Birthday</label>
                        <input type="date" id="birthday" name="birthday" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="address">Address</label>
                        <input type="text" id="address" name="address" placeholder="Enter your address" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" placeholder="Enter your password" required>
                        <div class="error-message"><?php echo $password_error; ?></div>
                    </div>
                    <div class="form-group">
                        <label for="mobile">Mobile Number</label>
                        <div style="display: flex; align-items: center;">
                            <img src="./img/philippines_flag.png" alt="Philippines Flag" style="height: 15px; margin-right: 10px;">
                            <span style="padding: 8px; border: 1px solid #ccc; border-radius: 5px; margin-right: 10px;">+63</span>
                            <input type="tel" id="mobile" name="mobile" placeholder="Enter your mobile number ex. 9989263405" required>
                        </div>
                        <div class="error-message mobile-error"><?php echo $mobile_error; ?></div>
                    </div>
                </div>
                <br>
                <div class="form-group">
                    <input type="submit" value="Register">
                </div>
            </form>
        </div>
    </section>

    <!-- Link JS -->
    <script>
        function validatePassword() {
            var password = document.getElementById("password").value;
            var passwordPattern = /^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;
            var passwordError = document.querySelector('.error-message');
            if (!passwordPattern.test(password)) {
                passwordError.textContent = "Password must be at least 8 characters long and include an uppercase letter, a lowercase letter, a number, and a special character.";
                return false;
            }
            passwordError.textContent = "";
            return true;
        }

        function validateForm() {
            var mobile = document.getElementById("mobile").value;
            var mobilePattern = /^9\d{9}$/;
            var mobileError = document.querySelector('.mobile-error');
            if (!mobilePattern.test(mobile)) {
                mobileError.textContent = "Mobile number must start with 9 and be 10 digits long.";
                return false;
            }
            mobileError.textContent = "";
            return validatePassword();
        }
    </script>
    <script src="assets/js/main.js"></script>
</body>

</html>
