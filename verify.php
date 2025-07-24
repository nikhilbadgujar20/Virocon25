<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $enteredOtp = $_POST['otp'];

    if ($enteredOtp == $_SESSION['otp']) {
        echo "Email verified successfully!";
        // Optionally: unset($_SESSION['otp']);
    } else {
        echo "Invalid OTP. Try again.";
    }
}
?>
