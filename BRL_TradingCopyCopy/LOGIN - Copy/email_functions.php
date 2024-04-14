<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Function to send a password reset email using PHPMailer
function sendPasswordResetEmail($useremail, $resetToken)
{
    $mail = new PHPMailer(true);
    try {
        //Server settings
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'brltrading101@gmail.com';
        $mail->Password   = 'BRLTrading@123';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        //Recipients
        $mail->setFrom('from@example.com', 'Your Name');
        $mail->addAddress($useremail); // Add a recipient

        //Content
        $mail->isHTML(true);
        $mail->Subject = 'Password Reset Request';
        $mail->Body    = "Click the following link to reset your password: <a href='http://localhost/BRL_TradingCopyCopy/LOGIN/login.phpreset_password.php?token=$resetToken'>Reset Password</a>";

        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}

?>
