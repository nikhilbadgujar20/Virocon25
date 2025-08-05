<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit();
}

// Set timeout in seconds (30 minutes = 1800 seconds)
$timeout = 1800;

// Check if session has timed out
if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY']) > $timeout) {
    session_unset();     // Unset $_SESSION
    session_destroy();   // Destroy session data
    header("Location: login.php?timeout=1");
    exit();
}

// Update last activity time
$_SESSION['LAST_ACTIVITY'] = time();
?>
