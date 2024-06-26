<?php

require __DIR__ . '/PHPMailer/src/Exception.php';
require __DIR__ . '/PHPMailer/src/PHPMailer.php';
require __DIR__ . '/PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

include "../connections.php";

// Function to send a password reset email using PHPMailer
function sendPasswordResetEmail($useremail, $resetToken)
{
    $mail = new PHPMailer(true);
    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'jocatayoc15@gmail.com'; // Change to the new email address
        $mail->Password   = 'bebe15jo'; // Update password if necessary
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        // Recipients
        $mail->setFrom('joannacatayoc12@gmail.com', 'brl'); // Change to the new email address and name

        $mail->addAddress($useremail); // Add a recipient

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Password Reset Request';
        $mail->Body    = "Click the following link to reset your password: <a href='http://localhost/BRL_TradingCopyCopy/LOGIN/login.phpreset_password.php?token=$resetToken'>Reset Password</a>";

        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['forgot_password'])) {
    $useremail = $_POST["useremail"];

    // Check if the email exists in the database
    $query = "SELECT * FROM users WHERE useremail = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $useremail);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        // Email exists, generate a random password reset token
        $token = bin2hex(random_bytes(16));

        // Update the user's record in the database with the token
        $update_query = "UPDATE users SET reset_token = ? WHERE useremail = ?";
        $update_stmt = $conn->prepare($update_query);
        $update_stmt->bind_param("ss", $token, $useremail);
        $update_stmt->execute();

        // Send the password reset email
        try {
            sendPasswordResetEmail($useremail, $token);
            echo 'Password reset email has been sent.';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$e->getMessage()}";
        }
    } else {
        // Email does not exist in the database
        echo "Email not found.";
    }
}
?>
