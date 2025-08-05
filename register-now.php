<?php
require_once 'conn.php';
require_once 'includes/PHPMailer-master/src/PHPMailer.php';
require_once 'includes/PHPMailer-master/src/SMTP.php';
require_once 'includes/PHPMailer-master/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// 🔐 Generate unique registration number
function generateRegistrationNumber($conn)
{
    $prefix = 'V25';
    do {
        $random = mt_rand(10000, 99999);
        $regNo = $prefix . $random;
        $stmt = $conn->prepare("SELECT registration_number FROM register WHERE registration_number = ?");
        $stmt->bind_param("s", $regNo);
        $stmt->execute();
        $result = $stmt->get_result();
    } while ($result && $result->num_rows > 0);
    return $regNo;
}

// ✅ Collect form data
$registrationNumber = generateRegistrationNumber($conn);
$email = $_POST['email'];
$firstName = $_POST['fname'];
$lastName = $_POST['lname'];
$title = $_POST['title'];
$gender = $_POST['gender'];
$organization = $_POST['organization'];
$delegateType = $_POST['delegate_type'];
$natureOfDelegate = $_POST['nature_of_delegate'];
$postalAddress = $_POST['postal_address'];
$city = $_POST['city'];
$pincode = $_POST['pin_code'];
$state = $_POST['state'];
$country = $_POST['country'];
$telephone = $_POST['telephone_no'];
$mobile = $_POST['mobile_no'];
$accompanyingPersons = $_POST['no_of_accompanying_persons'];
$Amount = $_POST['amount_payable'] ?? 0; // Default to 0 if not set
$attemptingAs = $_POST['Attempting_as'];
$areaofresearch = $_POST['area_of_research'] ?? ''; 

// ✅ Abstract fields (optional)
$abstractTitle = $_POST['abstract_title'] ?? '';
$abstractAuthors = $_POST['authors'] ?? '';
$abstractText = $_POST['abstract_text'] ?? '';
$abstractFilePath = '';
$fileBlob = null;

if (isset($_FILES['presentation_file']) && $_FILES['presentation_file']['error'] === UPLOAD_ERR_OK) {
    $fileTmp = $_FILES['presentation_file']['tmp_name'];
    $fileName = basename($_FILES['presentation_file']['name']);
    $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

    if (in_array($fileExt, ['pdf', 'docx'])) {
        $uploadDir = "uploads/abstracts";
        if (!file_exists($uploadDir)) mkdir($uploadDir, 0777, true);

        $abstractFilePath = "$uploadDir/{$registrationNumber}.$fileExt";
        move_uploaded_file($fileTmp, $abstractFilePath);
        $fileBlob = file_get_contents($abstractFilePath);
    }
}

$certificateFilePath = ''; // Declare default

if (isset($_FILES['student_proof_file']) && $_FILES['student_proof_file']['error'] === UPLOAD_ERR_OK) {
    $fileTmp = $_FILES['student_proof_file']['tmp_name'];
    $fileName = basename($_FILES['student_proof_file']['name']);
    $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

    if (in_array($fileExt, ['pdf', 'docx'])) {
        $uploadDir = "uploads/certificates";
        if (!file_exists($uploadDir)) mkdir($uploadDir, 0777, true);

        // Save with registration number
        $certificateFilePath = "$uploadDir/{$registrationNumber}.$fileExt";
        move_uploaded_file($fileTmp, $certificateFilePath);
    }
}


// ✅ Insert everything into `register` table
$stmt = $conn->prepare("INSERT INTO register (
    registration_number, email, first_name, last_name, title, gender,
    organization, delegate_type, nature_of_delegate, postal_address,
    city, pin_code, state, country, telephone_no, mobile_no,
    no_of_accompanying_persons, payment_amount, area_of_research, attempting_as,
    abstract_title, authors, abstract_text, file_path, cert_file_path, file_blob
) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

$null = null;
$stmt->bind_param(
    "sssssssssssssssssssssssssb",
    $registrationNumber,
    $email,
    $firstName,
    $lastName,
    $title,
    $gender,
    $organization,
    $delegateType,
    $natureOfDelegate,
    $postalAddress,
    $city,
    $pincode,
    $state,
    $country,
    $telephone,
    $mobile,
    $accompanyingPersons,
    $Amount,
    $areaofresearch,
    $attemptingAs,
    $abstractTitle,
    $abstractAuthors,
    $abstractText,
    $abstractFilePath,
    $certificateFilePath,
    $null
);

$stmt->send_long_data(22, $fileBlob);

if ($stmt->execute()) {
    $stmt->close();

    // ✅ Send confirmation email
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'badgujarnikhil.nb@gmail.com';
        $mail->Password   = 'dyft xlsd wwsq lwdw'; // Replace with actual app password
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;

        $mail->setFrom('badgujarnikhil.nb@gmail.com', 'Virocon Secretariat');
        $mail->addAddress($email, "$firstName $lastName");

        $mail->isHTML(true);
        $mail->Subject = 'VIROCON 2025 Registration Confirmation';
        $mail->Body = "
            <h2 style='color: #2c3e50;'>🎉 Thank You for Registering for VIROCON 2025!</h2>

            <p>Dear <strong>{$firstName} {$lastName}</strong>,</p>

            <p>We are delighted to confirm your successful registration for <strong>VIROCON 2025</strong>, the premier annual conference of the Indian Virological Society.</p>

            <p><strong>Your unique registration number:</strong> <span style='color: #007bff;'>{$registrationNumber}</span></p>

            <p>As a registered participant, you will gain access to keynote lectures, technical sessions, poster presentations, and networking events with leading experts in the field of virology from around the world.</p>

            ---

            <h4>🗓️ Event Details:</h4>
            <ul>
                <li><strong>Conference Dates:</strong> December 8–10, 2025</li>
                <li><strong>Venue:</strong> Conrad Hotel, Pune, Maharashtra, India</li>
                <li><strong>Hosted by:</strong> ICMR–National Institute of Virology, Pune</li>
                <li><strong>Theme:</strong> <em>“Harnessing Virology for One Health and Global Sustainability”</em></li>
            </ul>

            ---

            <h4>📌 What’s Next?</h4>
            <ul>
                <li>You will soon receive updates regarding abstract submission, accommodation, and travel assistance.</li>
                <li>Don’t forget to check your email regularly for important announcements and deadlines.</li>
                <li>If you haven’t submitted your abstract yet, you can do so by logging into the registration portal.</li>
            </ul>

            ---

            <h4>📞 Need Assistance?</h4>
            <p>If you have any questions regarding your registration, please feel free to contact our secretariat:</p>
            <ul>
                <li>Email: <a href='mailto:virocon2025@support.org'>virocon2025@support.org</a></li>
                <li>Phone: +91-9876543210</li>
            </ul>

            ---

            <p>We look forward to welcoming you at <strong>VIROCON 2025</strong> and hope you have a fruitful and memorable experience!</p>

            <hr>

            <p style='font-size: 0.9em; color: #555;'>
            Warm regards,<br>
            <strong>Organizing Team</strong><br>
            VIROCON 2025<br>
            <a href='https://virocon2025.org' target='_blank'>www.virocon2025.org</a>
            </p>
        ";
        $mail->send();

        header("Location: success.php");
        exit();
    } catch (Exception $e) {
        echo "Mail not sent. Error: " . $mail->ErrorInfo;
    }
} else {
    echo "❌ Registration Error: " . $stmt->error;
    $stmt->close();
}

$conn->close();
unset($_SESSION['otp_verified']);
