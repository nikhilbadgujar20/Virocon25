<?php
// Only handle POST request with at least one required field present
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['first_name'])) {

    // 1. Database connection
    $host = "localhost";
    $username = "root";
    $password = "root";
    $dbname = "virocon";

    $conn = new mysqli($host, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
}
?>
