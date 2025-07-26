<?php
require_once 'db.php';
require_once 'conn.php';
session_start();
$error = '';

// 🔐 Step 1: Insert admin only if not exists
$username = "admin";
$password = "admin123";

$checkStmt = $mysqli->prepare("SELECT id FROM admins WHERE username = ?");
$checkStmt->bind_param("s", $username);
$checkStmt->execute();
$checkStmt->store_result();

if ($checkStmt->num_rows === 0) {
    // Admin not found, insert it
    $hash = password_hash($password, PASSWORD_DEFAULT);
    $insertStmt = $mysqli->prepare("INSERT INTO admins (username, password_hash) VALUES (?, ?)");
    $insertStmt->bind_param("ss", $username, $hash);
    $insertStmt->execute();
}

// 🔐 Step 2: Handle login form POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $loginUser = $_POST['username'] ?? '';
    $loginPass = $_POST['password'] ?? '';

    $stmt = $mysqli->prepare("SELECT password_hash FROM admins WHERE username = ?");
    $stmt->bind_param("s", $loginUser);
    $stmt->execute();
    $stmt->bind_result($hash);

    if ($stmt->fetch() && password_verify($loginPass, $hash)) {
        $_SESSION['admin_logged_in'] = true;
        header('Location: dashboard.php');
        exit();
    } else {
        $error = "Invalid username or password";
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Login – Virocon</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex align-items-center" style="height:100vh;">
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card shadow-lg">
                <div class="card-body p-4">
                    <h4 class="mb-3 text-center">Admin Login</h4>
                    <?php if ($error): ?>
                        <div class="alert alert-danger py-1"><?= htmlspecialchars($error) ?></div>
                    <?php endif; ?>
                    <form method="POST" novalidate>
                        <div class="mb-3">
                            <label class="form-label">Username</label>
                            <input type="text" name="username" class="form-control" required autofocus>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <div class="d-grid">
                            <button class="btn btn-primary" type="submit">Login</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
                        