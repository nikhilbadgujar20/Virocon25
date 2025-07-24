<?php
session_start();
header('Content-Type: application/json');

$inputOtp = $_POST['otp'] ?? '';
$email = $_POST['email'] ?? '';

if (!isset($_SESSION['otp_email'], $_SESSION['otp_code'], $_SESSION['otp_expire'])) {
    exit(json_encode(['error' => 'No OTP session found']));
}

if (time() > $_SESSION['otp_expire']) {
    exit(json_encode(['error' => 'OTP expired']));
}

if ($email !== $_SESSION['otp_email']) {
    exit(json_encode(['error' => 'Email mismatch']));
}

if ($inputOtp == $_SESSION['otp_code']) {
    $_SESSION['otp_verified'] = true;
    echo json_encode(['status' => 'verified']);
} else {
    echo json_encode(['status' => 'failed']);
}
?>