<?php
include "../connections.php";
session_start();

// Check if the user is logged in, if not then redirect to login page
if (!isset($_SESSION['useremail'])) {
    header("Location: ../LOGIN/login.php");
    exit();
}

// Retrieve the useremail from the session
$useremail = $_SESSION['useremail'];

// Check database connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch user details from the database using a join
$sql = "SELECT u.user_id, u.useremail, ud.full_name, ud.gender, ud.birthday, ud.mobile_number
        FROM users u
        LEFT JOIN user_details ud ON u.user_id = ud.user_id
        WHERE u.useremail = ?";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("Query preparation failed: " . $conn->error);
}
$stmt->bind_param("s", $useremail);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Initialize user details with default values if they are null
$user_details = [
    'user_id' => isset($user['user_id']) ? $user['user_id'] : '',
    'full_name' => isset($user['full_name']) ? $user['full_name'] : '',
    'gender' => isset($user['gender']) ? $user['gender'] : 'Male',
    'useremail' => isset($user['useremail']) ? $user['useremail'] : '',
    'birthday' => isset($user['birthday']) ? $user['birthday'] : '',
    'mobile_number' => isset($user['mobile_number']) ? $user['mobile_number'] : '',
];

// Update user details
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $full_name = $_POST['full_name'];
    $gender = $_POST['gender'];
    $email = $_POST['email'];
    $birthday = $_POST['birthday'];
    $password = $_POST['password'];
    $mobile_number = $_POST['mobile_number'];

    // Start transaction
    $conn->begin_transaction();

    try {
        // Update users table
        $update_user_sql = "UPDATE users SET useremail = ? WHERE user_id = ?";
        $update_user_stmt = $conn->prepare($update_user_sql);
        if (!$update_user_stmt) {
            throw new Exception("Update user query preparation failed: " . $conn->error);
        }
        $update_user_stmt->bind_param("si", $email, $user['user_id']);
        $update_user_stmt->execute();

        // Update password if provided
        if (!empty($password)) {
            $hashed_password = password_hash($password, PASSWORD_BCRYPT);
            $update_password_sql = "UPDATE users SET password = ? WHERE user_id = ?";
            $update_password_stmt = $conn->prepare($update_password_sql);
            if (!$update_password_stmt) {
                throw new Exception("Update password query preparation failed: " . $conn->error);
            }
            $update_password_stmt->bind_param("si", $hashed_password, $user['user_id']);
            $update_password_stmt->execute();
        }

        // Update or insert user_details table
        $update_details_sql = "INSERT INTO user_details (user_id, full_name, gender, birthday, mobile_number) VALUES (?, ?, ?, ?, ?)
                               ON DUPLICATE KEY UPDATE full_name = VALUES(full_name), gender = VALUES(gender), birthday = VALUES(birthday), mobile_number = VALUES(mobile_number)";
        $update_details_stmt = $conn->prepare($update_details_sql);
        if (!$update_details_stmt) {
            throw new Exception("Update details query preparation failed: " . $conn->error);
        }
        $update_details_stmt->bind_param("issss", $user['user_id'], $full_name, $gender, $birthday, $mobile_number);
        $update_details_stmt->execute();

        // Commit transaction
        $conn->commit();

        $success_message = "Details updated successfully!";
        $user_details = ['full_name' => $full_name, 'gender' => $gender, 'useremail' => $email, 'birthday' => $birthday, 'mobile_number' => $mobile_number];
    } catch (Exception $e) {
        // Rollback transaction in case of error
        $conn->rollback();
        $error_message = "Failed to update details. " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
<title>BRL Trading</title>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="../Admin/assets/imgs/logo_brl.png">
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel/slick/slick.css"/>
  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel/slick/slick-theme.css"/>
    <link rel="icon" href="../Admin/assets/imgs/logo_brl.png">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <!-- Box Icons  -->
    <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
    <!-- Styles  -->
    <link rel="stylesheet" href="css1/user_details.css">
    <link rel="icon" href="../Admin/assets/imgs/logo_brl.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel/slick/slick.css"/>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel/slick/slick-theme.css"/>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&family=Montserrat:wght@400;700&display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <style>
        /* Modal styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.4);
        }
        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 25%;
            text-align: center;
            border-radius: 8px;
        }
        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 20px;
            font-weight: bold;
        }
        .modal-header .close {
            cursor: pointer;
            font-size: 28px;
        }
        .modal-body {
            margin: 20px 0;
        }
        .modal-footer {
            display: flex;
            justify-content: space-around;
        }
        .modal-footer button {
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            font-size: 16px;
            border-radius: 5px;
        }
        .modal-footer .logout {
            background-color: red;
            color: white;
        }
        .modal-footer .cancel {
            background-color: #0275d8;
            color: white;
        }

        /* Eye toggle styles */
        .toggle-password {
            cursor: pointer;
            position: absolute;
            right: 15px;
            top: 75%;
            transform: translateY(-50%);
            color: #777;
            font-size: 20px;
        }
    </style>
</head>

<body>
  <header>
    <div class="logo">
      <a href="index.php">
        <img src="../Admin/assets/imgs/logo_brl.png" alt="BRL Trading Logo">
      </a>
    </div>
    <div class="header-right">
      <div class="search">
        <input type="text" placeholder="Search">
        <button type="submit"><i class="fas fa-search"></i></button>
      </div>
      <div class="icons">
        <div class="icon user">
          <a href="user_details.php">
            <button type="button"><i class="fas fa-user"></i></button>
          </a>
        </div>
        <div class="icon cart">
          <a href="view_cart.php">
            <button type="button">
              <i class="fas fa-shopping-cart"></i>
            </button>
          </a>
        </div>
        <div class="icon wishlist">
          <a href="wishlist.php">
            <button type="button"><i class="fas fa-heart"></i></button>
          </a>
        </div>
        <div class="icon messages">
          <a href="message1.php">
            <button type="button"><i class="fas fa-comment"></i></button>
          </a>
        </div>
      </div>
    </div>
  </header>
 

<div class="main-content">
    <div class="sidebar">
        <br><br><br><br>
        <!-- ========== Logo ============  -->
        <a href="#" class="logo-box">
            <i class='bx bx-user'></i>
            <div class="logo-name">My Account</div>
        </a>

        <!-- ========== List ============  -->
        <ul class="sidebar-list">
            <!-- -------- Non Dropdown List Item ------- -->
            <li>
                <div class="title">
                    <a href="#" class="link">
                        <i class='bx bx-user-circle'></i>
                        <span class="name">Details</span>
                    </a>
                </div>
            </li>

            <!-- -------- Non Dropdown List Item ------- -->
            <li>
                <div class="title">
                    <a href="user_orders.php" class="link">
                        <i class='bx bx-cart'></i>
                        <span class="name">Orders</span>
                    </a>
                </div>
            </li>

            <!-- -------- Non Dropdown List Item ------- -->
            <li>
                <div class="title">
                    <a href="#" class="link" onclick="openLogoutModal()">
                        <i class='bx bx-log-out'></i>
                        <span class="name">Sign Out</span>
                    </a>
                </div>
            </li>
        </ul>
    </div>

    <!-- ============= Home Section =============== -->
    <br>
    <section class="home">
    <div class="container">
        <h2>My Details</h2>
        <?php if (isset($success_message)) { echo "<p class='message'>$success_message</p>"; } ?>
        <?php if (isset($error_message)) { echo "<p class='message error'>$error_message</p>"; } ?>
        <form method="POST" action="">
            <div class="form-group">
                <label for="full_name">Full Name:</label>
                <input type="text" id="full_name" name="full_name" value="<?php echo htmlspecialchars($user_details['full_name']); ?>" required>
            </div>
            <div class="form-group">
                <label for="gender">Gender:</label>
                <select id="gender" name="gender" required>
                    <option value="Male" <?php echo ($user_details['gender'] == 'Male') ? 'selected' : ''; ?>>Male</option>
                    <option value="Female" <?php echo ($user_details['gender'] == 'Female') ? 'selected' : ''; ?>>Female</option>
                    <option value="Other" <?php echo ($user_details['gender'] == 'Other') ? 'selected' : ''; ?>>Other</option>
                </select>
            </div>
            <div class="form-group">
                <label for="email">Email Address:</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user_details['useremail']); ?>" required>
            </div>
            <div class="form-group">
                <label for="birthday">Birthday:</label>
                <input type="date" id="birthday" name="birthday" value="<?php echo htmlspecialchars($user_details['birthday']); ?>" required>
            </div>
            <div class="form-group" style="position: relative;">
                <label for="password">Change Password:</label>
                <input type="password" id="password" name="password" placeholder="Enter new password">
                <span class="toggle-password" onclick="togglePasswordVisibility()"><i class="material-icons">visibility</i></span>
            </div>
            <div class="form-group">
                <label for="mobile_number">Mobile Number:</label>
                <input type="text" id="mobile_number" name="mobile_number" value="<?php echo htmlspecialchars($user_details['mobile_number']); ?>" required>
            </div>
            <div class="form-group">
                <button type="submit">Save</button>
            </div>
        </form>
    </div>
    </section>
</div>

<!-- Logout Modal -->
<div id="logoutModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <span>Logout</span>
            <span class="close" onclick="closeLogoutModal()">&times;</span>
        </div>
        <div class="modal-body">
            Are you sure you want to log out?
        </div>
        <div class="modal-footer">
            <button class="logout" onclick="confirmLogout()">Logout</button>
            <button class="cancel" onclick="closeLogoutModal()">Cancel</button>
        </div>
    </div>
</div>

<!-- Link JS -->
<script src="assets/js/main.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel/slick/slick.min.js"></script>
<script>
    // Open modal
    function openModal(productId) {
        $('#modal-' + productId).css('display', 'block');
    }

    // Close modal
    function closeModal(productId) {
        $('#modal-' + productId).css('display', 'none');
    }

    // Toggle wishlist
    function toggleWishlist(element) {
        $(element).toggleClass('active');
    }

    // Add to cart
    function addToCart(productId, productName, productImage, productPrice) {
        var quantity = $('#quantity-' + productId).val();
        var cart = JSON.parse(localStorage.getItem('cart')) || [];
        var cartItem = {
            id: productId,
            name: productName,
            image: productImage,
            price: productPrice,
            quantity: quantity
        };

        // Add the product to the cart array
        cart.push(cartItem);
        localStorage.setItem('cart', JSON.stringify(cart));

        // Redirect to the cart page
        window.location.href = 'view_cart.php';
    }

    // Buy now
    function buyNow(productId) {
        var quantity = $('#quantity-' + productId).val();
        // Buy now logic
        console.log('Buy now:', productId, 'Quantity:', quantity);
    }

    // Dropdown functionality
    $('nav ul li').hover(
        function() {
            $(this).children('.dropdown').stop(true, false, true).slideToggle(300);
        }
    );

    // Open logout modal
    function openLogoutModal() {
        $('#logoutModal').css('display', 'block');
    }

    // Close logout modal
    function closeLogoutModal() {
        $('#logoutModal').css('display', 'none');
    }

    // Confirm logout
    function confirmLogout() {
        window.location.href = 'logout.php';
    }

    // Toggle password visibility
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
</script>
</body>
</html>
