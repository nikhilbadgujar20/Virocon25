<?php
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $registrationNumber = $_POST['registration_number'];
    $title = $_POST['title'];
    $authors = $_POST['authors'];
    $abstractText = $_POST['abstract_text'];

    // Word limits
    if (str_word_count($title) > 25) {
        exit("Title exceeds 25 words.");
    }
    if (str_word_count($abstractText) > 250) {
        exit("Abstract text exceeds 250 words.");
    }

    // File check
    $file = $_FILES['abstract_file'];
    $allowedExts = ['pdf', 'doc', 'docx'];
    $fileExt = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

    if (!in_array($fileExt, $allowedExts)) {
        exit("Only PDF, DOC, and DOCX files are allowed.");
    }

    if ($file['size'] > 5 * 1024 * 1024) {
        exit("File must be less than 5MB.");
    }

    // Upload
    $uploadDir = 'uploads/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir);
    }
    $newFileName = uniqid() . '.' . $fileExt;
    $targetFile = $uploadDir . $newFileName;

    if (!move_uploaded_file($file['tmp_name'], $targetFile)) {
        exit("Failed to upload file.");
    }

    // Store in DB
    $stmt = $conn->prepare("UPDATE register SET abstract_title = ?, abstract_authors = ?, abstract_text = ?, abstract_file_path = ? WHERE registration_number = ?");
    $stmt->bind_param("sssss", $title, $authors, $abstractText, $targetFile, $registrationNumber);

    if ($stmt->execute()) {
        echo "Abstract submitted successfully!";
    } else {
        echo "Database error: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
}
?>
