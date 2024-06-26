<?php
// Include the database connection file
include 'connections.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $full_name = $_POST['full-name'];
    $gender = $_POST['gender'];
    $address = $_POST['address'];
    $birthday = $_POST['birthday'];
    $password = $_POST['password'];
    $mobile_number = $_POST['mobile'];

    // Server-side password validation
    $password_pattern = "/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/";
    $mobile_pattern = "/^9\d{9}$/";
    if (!preg_match($password_pattern, $password)) {
        $message = "Password does not meet the requirements.";
    } elseif (!preg_match($mobile_pattern, $mobile_number)) {
        $message = "Mobile number must start with 9 and be 10 digits long.";
    } else {
        // Hash the password for security
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Prepare and bind
        $stmt = $conn->prepare("INSERT INTO user_details (full_name, gender, address, birthday, password, mobile_number) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $full_name, $gender, $address, $birthday, $hashed_password, $mobile_number);

        // Execute the statement
        if ($stmt->execute()) {
            // Redirect to login page after successful registration
            header("Location: user_details.php");
            exit(); // Make sure to call exit after redirection
        } else {
            $message = "Error: " . $stmt->error;
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
    <link rel="stylesheet" href="css/user_register.css">
    <link rel="icon" href="assets/img/logo_brl.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel/slick/slick.css"/>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel/slick/slick-theme.css"/>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&family=Montserrat:wght@400;700&display=swap">
</head>

<body>
    <!-- ============= Home Section =============== -->
    <br>
    <section class="home">
        <div class="form-container">
            <h2>Register Account</h2>
            <?php
            if (isset($message)) {
                echo "<p>$message</p>";
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
                        <label for="address">Address</label>
                        <input type="text" id="address" name="address" placeholder="Enter your address" required>
                    </div>
                    <div class="form-group">
                        <label for="birthday">Birthday</label>
                        <input type="date" id="birthday" name="birthday" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" placeholder="Enter your password" required>
                        <small>Password must be at least 8 characters long and include an uppercase letter, a lowercase letter, a number, and a special character.</small>
                    </div>
                    <div class="form-group">
                        <label for="mobile">Mobile Number</label>
                        <div style="display: flex; align-items: center;">
                            <img src="philippines_flag.png" alt="Philippines Flag" style="height: 15px; margin-right: 10px;">
                            <span style="padding: 8px; border: 1px solid #ccc; border-radius: 5px; margin-right: 10px;">+63</span>
                            <input type="tel" id="mobile" name="mobile" placeholder="Enter your mobile number" required>
                        </div>
                        <small>Mobile number must start with 9 and be 10 digits long. <br>ex. 9989263405</small>
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
            if (!passwordPattern.test(password)) {
                alert("Password does not meet the requirements.");
                return false;
            }
            return true;
        }

        function validateForm() {
            var mobile = document.getElementById("mobile").value;
            var mobilePattern = /^9\d{9}$/;
            if (!mobilePattern.test(mobile)) {
                alert("Mobile number must start with 9 and be 10 digits long.");
                return false;
            }
            return validatePassword();
        }
    </script>
    <script src="assets/js/main.js"></script>
</body>

</html>
