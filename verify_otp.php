<?php
session_start();
header('Content-Type: application/json');

$inputOtp = $_POST['otp'] ?? '';
$email = $_POST['email'] ?? '';

// Validate OTP session exists
if (!isset($_SESSION['otp_email'], $_SESSION['otp_code'], $_SESSION['otp_expire'])) {
    echo json_encode(['error' => 'No OTP session found']);
    exit;
}

// Check expiration
if (time() > $_SESSION['otp_expire']) {
    echo json_encode(['error' => 'OTP expired']);
    exit;
}

// Email match
if ($email !== $_SESSION['otp_email']) {
    echo json_encode(['error' => 'Email mismatch']);
    exit;
}

// Match OTP
if ($inputOtp == $_SESSION['otp_code']) {
    $_SESSION['otp_verified'] = true;
    echo json_encode(['status' => 'verified']);
} else {
    echo json_encode(['status' => 'failed']);
}
?>
