<?php
session_start();

// Check if the user is not logged in
if (!isLoggedIn()) {
    $_SESSION['msg'] = "You must log in first";
    header('location: ../LOGIN/login.php');
    exit;
}
