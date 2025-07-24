<?php
require 'includes/PHPMailer-master/src/PHPMailer.php';
require 'includes/PHPMailer-master/src/SMTP.php';
require 'includes/PHPMailer-master/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once 'auth.php';
require_once 'db.php';
header('Content-Type: application/json');

// Validate inputs
$id = (int)($_POST['id'] ?? 0);
$action = $_POST['action'] ?? '';

if (!in_array($action, ['accepted', 'rejected'])) {
    exit(json_encode(['error' => 'Invalid action']));
}

// Update registration status
$stmt = $mysqli->prepare("UPDATE register SET status=? WHERE id=?");
$stmt->bind_param('si', $action, $id);
if (!$stmt->execute()) {
    exit(json_encode(['error' => 'DB update failed']));
}

// Get user details
$res = $mysqli->query("SELECT email, first_name FROM register WHERE id=" . $id);
$user = $res->fetch_assoc();
if (!$user) {
    exit(json_encode(['error' => 'User not found']));
}

// Send email
$mail = new PHPMailer(true);
try {
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'badgujarnikhil.nb@gmail.com';   // ✅ Your Gmail
    $mail->Password   = 'dyft xlsd wwsq lwdw';        // ✅ App password here
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;

    $mail->setFrom('pankajthitame2024lll@gmail.com', 'Virocon Secretariat');
    $mail->addAddress($user['email'], $user['first_name']);

    $mail->isHTML(true);
    $mail->Subject = "[Virocon] Registration " . ucfirst($action);
    $mail->Body    = "Dear <b>" . htmlspecialchars($user['first_name']) . "</b>,<br><br>" .
        "Your registration for VIROCON has been <b>" . strtoupper($action) . "</b>.<br>" .
        ($action === 'accepted'
            ? "We look forward to your participation in the conference."
            : "Unfortunately, we are unable to proceed with your registration.") .
        "<br><br>Regards,<br>Virocon Conference Team";

    $mail->send();
    echo json_encode(['status' => 'ok']);
} catch (Exception $e) {
    echo json_encode(['error' => 'Mail Error: ' . $mail->ErrorInfo]);
}
