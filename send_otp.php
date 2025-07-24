<?php
session_start();

require 'includes/PHPMailer-master/src/PHPMailer.php';
require 'includes/PHPMailer-master/src/SMTP.php';
require 'includes/PHPMailer-master/src/Exception.php';
use PHPMailer\PHPMailer\PHPMailer;

header('Content-Type: application/json');

$email = $_POST['email'] ?? '';
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    exit(json_encode(['error' => 'Invalid email']));
}

$otp = rand(100000, 999999);
$_SESSION['otp_email'] = $email;
$_SESSION['otp_code'] = $otp;
$_SESSION['otp_expire'] = time() + 600; // 10 mins

$mail = new PHPMailer(true);
try {
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'badgujarnikhil.nb@gmail.com';
    $mail->Password = 'dyft xlsd wwsq lwdw';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    $mail->setFrom('badgujarnikhil.nb@gmail.com', 'Virocon Secretariat');
    $mail->addAddress($email);
    $mail->isHTML(true);
    $mail->Subject = 'Your OTP for VIROCON 2025 Verification';

    $mail->Body = "
        <h2>Email Verification - VIROCON 2025</h2>
        <p>Dear <strong>{$firstName} {$lastName}</strong>,</p>
        <p>Thank you for starting your registration for <strong>VIROCON 2025</strong>.</p>
        <p>Please use the following One-Time Password (OTP) to verify your email address:</p>
        <h3 style='color: #007bff;'>$otp</h3>
        <p>This OTP is valid for <strong>10 minutes</strong>. Do not share this code with anyone.</p>
        <hr>
        <p>If you did not initiate this request, please ignore this email.</p>
        <p>Regards,<br>Organizing Team<br>VIROCON 2025</p>
    ";

    $mail->send();
    echo json_encode(['status' => 'OTP Sent']);
} catch (Exception $e) {
    echo json_encode(['error' => 'Mail Error: ' . $mail->ErrorInfo]);
}
?>