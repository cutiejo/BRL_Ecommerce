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
    <link rel="stylesheet" href="assets/css/user_details.css">
    <link rel="icon" href="assets/img/logo_brl.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel/slick/slick.css"/>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel/slick/slick-theme.css"/>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&family=Montserrat:wght@400;700&display=swap">
</head>

<body>
    <header>
        <div class="logo">
            <img src="assets/img/logo_brl.png" alt="BRL Trading Logo">
        </div>
        <div class="header-right">
            <div class="search">
                <input type="text" placeholder="Search">
                <button type="submit"><i class="fas fa-search"></i></button>
            </div>
            <div class="icons">
                <div class="icon user">
                    <button type="button"><i class="fas fa-user"></i></button>
                </div>
                <div class="icon cart">
                    <button type="button"><i class="fas fa-shopping-cart"></i></button>
                    <span class="badge"></span>
                </div>
                <div class="icon wishlist">
                    <button type="button"><i class="fas fa-heart"></i></button>
                </div>
                <div class="icon messages">
                    <button type="button"><i class="fas fa-comment"></i></button>
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
                        <a href="#" class="link">
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
            <div class="form-container">
                <h2>My Details</h2>
                <form action="#" method="post">
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
                            <label for="email">Email Address</label>
                            <input type="email" id="email" name="email" placeholder="Enter your email" required>
                        </div>
                        <div class="form-group">
                            <label for="birthday">Birthday</label>
                            <input type="date" id="birthday" name="birthday" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="password">Change Password</label>
                            <input type="password" id="password" name="password">
                        </div>
                        <div class="form-group">
                            <label for="mobile">Mobile Number</label>
                            <div style="display: flex; align-items: center;">
                                <img src="assets/img/philippines_flag.png" alt="Philippines Flag" style="height: 15px; margin-right: 10px;">
                                <span style="padding: 8px; border: 1px solid #ccc; border-radius: 5px; margin-right: 10px;">+63</span>
                                <input type="tel" id="mobile" name="mobile" placeholder="Enter your mobile number" required>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="form-row">
                        <div class="form-group">
                            <input type="submit" value="Save">
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </div>

    <!-- Link JS -->
    <script src="assets/js/main.js"></script>
</body>

</html>

