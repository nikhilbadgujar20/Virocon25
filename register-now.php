<?php
session_start();
require_once 'conn.php'; // ✅ This initializes $conn
require_once 'db.php';

require 'includes/PHPMailer-master/src/PHPMailer.php';
require 'includes/PHPMailer-master/src/SMTP.php';
require 'includes/PHPMailer-master/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// 1. OTP verification check
if (!isset($_SESSION['otp_verified']) || $_SESSION['otp_verified'] !== true) {
    exit('OTP verification required');
}

// 2. Check if form submitted
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['email'])) {
    exit('Invalid request.');
}

// 3. Collect and sanitize form data
$email = $_POST['email'] ?? '';
$firstName = $_POST['first_name'] ?? '';
$lastName = $_POST['last_name'] ?? '';
$title = $_POST['title'] ?? '';
$gender = $_POST['gender'] ?? '';
$organization = $_POST['organization'] ?? '';
$delegateType = $_POST['delegate_type'] ?? '';
$natureOfDelegate = $_POST['nature_of_delegate'] ?? '';
$postalAddress = $_POST['postal_address'] ?? '';
$city = $_POST['city'] ?? '';
$pincode = $_POST['pin_code'] ?? '';
$state = $_POST['state'] ?? '';
$country = $_POST['country'] ?? '';
$telephone = $_POST['telephone_no'] ?? '';
$mobile = $_POST['mobile_no'] ?? '';
$accompanyingPersons = (int) ($_POST['no_of_accompanying_persons'] ?? 0);

// 4. Insert into DB
$stmt = $conn->prepare("INSERT INTO register (
    email, first_name, last_name, title, gender, organization, delegate_type,
    nature_of_delegate, postal_address, city, pin_code, state, country,
    telephone_no, mobile_no, no_of_accompanying_persons
) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}

$stmt->bind_param("sssssssssssssssi",
    $email, $firstName, $lastName, $title, $gender, $organization, $delegateType,
    $natureOfDelegate, $postalAddress, $city, $pincode, $state, $country,
    $telephone, $mobile, $accompanyingPersons
);

if ($stmt->execute()) {
    // 5. Send confirmation email
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'badgujarnikhil.nb@gmail.com';
        $mail->Password = 'dyft xlsd wwsq lwdw'; // 🔐 Make sure this is a valid app password
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('badgujarnikhil.nb@gmail.com', 'Virocon Secretariat');
        $mail->addAddress($email, $firstName . ' ' . $lastName);

        $mail->isHTML(true);
        $mail->Subject = 'VIROCON 2025 Registration Confirmation';
        $mail->Body = "
            <h2>Thank you for registering!</h2>
            <p>Dear <strong>{$firstName} {$lastName}</strong>,</p>
            <p>Your registration for <strong>VIROCON 2025</strong> has been successfully received.</p>
            <p>We look forward to seeing you at the event!</p>
            <hr>
            <p>Regards,<br>Organizing Team<br>VIROCON 2025</p>
        ";

        $mail->send();
        header("Location: success.php");
        exit();

    } catch (Exception $e) {
        echo "<div class='alert alert-warning text-center mt-4'>
                Registration successful, but email could not be sent.<br>
                Mailer Error: {$mail->ErrorInfo}
              </div>";
    }

} else {
    echo "<div class='alert alert-danger text-center mt-4'>
            Registration failed. Please try again.
          </div>";
}

$stmt->close();
$conn->close();

// Clear OTP flag
unset($_SESSION['otp_verified']);
?>
