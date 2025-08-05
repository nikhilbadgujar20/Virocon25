<?php
// download.php
require_once 'db.php';

$reg = $_GET['registration_number'] ?? '';
if (!$reg) {
    http_response_code(400);
    exit('Missing registration number');
}

$stmt = $mysqli->prepare("SELECT file_path FROM abstracts WHERE registration_number = ?");
$stmt->bind_param('s', $reg);
$stmt->execute();
$res = $stmt->get_result();
if (!$row = $res->fetch_assoc()) {
    http_response_code(404);
    exit('File not found');
}

$path = $row['file_path'];
if (!file_exists($path)) {
    http_response_code(404);
    exit('File not on server');
}

header('Content-Description: File Transfer');
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename="' . basename($path) . '"');
header('Content-Length: ' . filesize($path));
readfile($path);
exit();
?>