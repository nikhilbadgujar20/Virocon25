<?php
// Only handle POST request with at least one required field present

// 1. Database connection
$host = "localhost";
$username = "root";
$password = "virocon2025";
$dbname = "virocon";
$port = 3306;
$conn = new mysqli($host, $username, $password, $dbname, $port);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
