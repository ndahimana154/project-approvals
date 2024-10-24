<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require './vendor/autoload.php';

function sendOTP($to, $otp)
{
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com'; // Set your SMTP server
        $mail->SMTPAuth   = true;
        $mail->Username   = 'ndahimana154@gmail.com'; // SMTP username
        $mail->Password   = 'ulsh meag wfav afkz'; // SMTP password
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;

        // Sender and recipient settings
        $mail->setFrom('reneekerly@gmail.com', 'UTB Projects Approval System');
        $mail->addAddress($to); // Send to the user's email

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Your OTP for Password Reset';
        $mail->Body    = "Your OTP for resetting your password is: <b>$otp</b>";

        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}
