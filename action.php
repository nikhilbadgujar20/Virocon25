<?php
require 'includes/PHPMailer-master/src/PHPMailer.php';
require 'includes/PHPMailer-master/src/SMTP.php';
require 'includes/PHPMailer-master/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

session_start();
require_once 'db.php';
header('Content-Type: application/json');

// ✅ Ensure admin is logged in
$admin = $_SESSION['admin_username'] ?? null || null && $_SESSION['admin_logged_in'] === true;
if (!$admin) {
    exit(json_encode(['error' => 'Unauthorized. Admin login required.']));
}

// ✅ Get POST inputs
$registration_number = trim($_POST['registration_number'] ?? '');
$action = $_POST['action'] ?? '';

// ✅ Validate input
$validActions = ['accepted_oral', 'accepted_poster', 'rejected'];
if (empty($registration_number) || !in_array($action, $validActions)) {
    exit(json_encode(['error' => 'Invalid input']));
}

// ✅ Update status in DB and track reviewer
$stmt = $mysqli->prepare("
    UPDATE register 
    SET status = ?, reviewed_by = ?, reviewed_at = NOW() 
    WHERE registration_number = ?
");
$stmt->bind_param('sss', $action, $admin, $registration_number);
if (!$stmt->execute()) {
    exit(json_encode(['error' => 'Failed to update registration']));
}
$stmt->close();

// ✅ Fetch user info
$stmt = $mysqli->prepare("SELECT registration_number, first_name, last_name, email FROM register WHERE registration_number = ?");

$stmt->bind_param('s', $registration_number);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

if (!$user) {
    exit(json_encode(['error' => 'User not found']));
}

// ✅ Compose email content
$subject = "[Virocon] Registration Status";

switch ($action) {
    case 'accepted_oral':
        $registrationNumber = $user['registration_number'];
        $firstName = $user['first_name'];
        $lastName = $user['last_name'];

        $paymentLink = "http://10.1.8.33/v25c/pay-now.php?reg_no=" . urlencode($registrationNumber) . "&name=" . urlencode($firstName . ' ' . $lastName);

        $statusText = "ACCEPTED as an ORAL presenter";
        $message = "
           <p>Dear <strong>{$firstName} {$lastName}</strong>,</p>

            
            <p>We are pleased to inform you that your abstract has been <b>accepted for oral presentation</b> at <b>VIROCON 2025</b>, the annual conference of the Indian Virological Society.</p>
            
            <p>Your contribution has been reviewed by our scientific committee and found to be of significant merit. We look forward to your active participation in the scientific sessions.</p>
            
            <p>Further details regarding the presentation schedule, guidelines, and registration will be communicated to you shortly.</p>
            
            <p>Thank you for your interest in VIROCON 2025.</p>
            
            <p>Best regards,<br>
            Organizing Committee<br>
            VIROCON 2025</p>
        ";
        break;

    case 'accepted_poster':
        $registrationNumber = $user['registration_number'];
        $firstName = $user['first_name'];
        $lastName = $user['last_name'];

        $paymentLink = "http://10.1.8.33/v25c/pay-now.php?reg_no=" . urlencode($registrationNumber) . "&name=" . urlencode($firstName . ' ' . $lastName);

        $statusText = "ACCEPTED as a POSTER presenter";
        $message = "
            <p>Dear <strong>{$firstName} {$lastName}</strong>,</p>
            
            <p>We are pleased to inform you that your abstract has been <b>accepted for poster presentation</b> at <b>VIROCON 2025</b>, the annual conference of the Indian Virological Society.</p>
            
            <p>Your submission has undergone peer review and was selected for presentation in the poster session. Poster guidelines and session details will be shared soon.</p>
            
            <p>We look forward to your participation and a vibrant exchange of ideas during the conference.</p>
            
            <p>Best regards,<br>
            Organizing Committee<br>
            VIROCON 2025</p>
        ";
        break;

    case 'rejected':
        $statusText = "REJECTED";
        $message = "
           <p>Dear <strong>{$firstName} {$lastName}</strong>,</p>
            
            <p>We regret to inform you that your abstract submission for <b>VIROCON 2025</b> has not been accepted for presentation this year.</p>
            
            <p>We appreciate the time and effort you put into your submission and encourage you to participate in the conference as a delegate. We hope to receive your contributions in future editions of the conference.</p>
            
            <p>Thank you for your interest in VIROCON 2025.</p>
            
            <p>Sincerely,<br>
            Organizing Committee<br>
            VIROCON 2025</p>
        ";
        break;
}


// ✅ Send email
$mail = new PHPMailer(true);
try {
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'badgujarnikhil.nb@gmail.com';
    $mail->Password   = 'dyft xlsd wwsq lwdw'; // app password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;

    $mail->setFrom('badgujarnikhil.nb@gmail.com', 'Virocon Secretariat');
    $mail->addAddress($user['email'], $user['first_name']);

    $mail->isHTML(true);
    $mail->Subject = $subject;
    $paymentLink = "http://10.1.8.33/v25c/pay-now.php?reg_no=" . urlencode($registrationNumber) . "&name=" . urlencode($firstName . ' ' . $lastName);

    $mail->Body = "
    <h2 style='color: #2c3e50;'>🎉 Thank You for Registering for VIROCON 2025!</h2>

    <p>Dear <strong>{$firstName} {$lastName}</strong>,</p>

    <p>We are delighted to confirm your successful registration for <strong>VIROCON 2025</strong>, the premier annual conference of the Indian Virological Society.</p>

    <p><strong>Your unique registration number:</strong> <span style='color: #007bff;'>{$registrationNumber}</span></p>

    <p>To complete your registration, please proceed with payment using the link below:</p>

   <p>
    <a href='{$paymentLink}' style='background-color: #28a745; color: white; padding: 10px 18px; text-decoration: none; border-radius: 5px; display: inline-block;'>
        💳 Proceed to Payment
    </a>
</p>


    <p><small>If the button doesn’t work, copy and paste this URL into your browser: <br><code>{$paymentLink}</code></small></p>

    <hr>

    <h4>🗓️ Event Details:</h4>
    <ul>
        <li><strong>Conference Dates:</strong> December 8–10, 2025</li>
        <li><strong>Venue:</strong> Conrad Hotel, Pune, Maharashtra, India</li>
        <li><strong>Hosted by:</strong> ICMR–National Institute of Virology, Pune</li>
        <li><strong>Theme:</strong> <em>“Harnessing Virology for One Health and Global Sustainability”</em></li>
    </ul>

    <h4>📌 What’s Next?</h4>
    <ul>
        <li>You’ll receive updates regarding abstract submission, accommodation, and travel assistance.</li>
        <li>Check your email regularly for important announcements and deadlines.</li>
        <li>If you haven’t submitted your abstract yet, you can do so by logging into the registration portal.</li>
    </ul>

    <h4>📞 Need Assistance?</h4>
    <ul>
        <li>Email: <a href='mailto:virocon2025@support.org'>virocon2025@support.org</a></li>
        <li>Phone: +91-9876543210</li>
    </ul>

    <p>We look forward to welcoming you at <strong>VIROCON 2025</strong>!</p>

    <hr>
    <p style='font-size: 0.9em; color: #555;'>
        Warm regards,<br>
        <strong>Organizing Team</strong><br>
        VIROCON 2025<br>
        <a href='https://virocon2025.org' target='_blank'>www.virocon2025.org</a>
    </p>
";


    $mail->send();
    echo json_encode(['status' => 'ok']);
} catch (Exception $e) {
    echo json_encode(['error' => 'Mail Error: ' . $mail->ErrorInfo]);
}
