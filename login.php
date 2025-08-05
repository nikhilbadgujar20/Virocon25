<?php
session_start(); // ✅ Required for using $_SESSION

require_once 'db.php';
require_once 'conn.php';
$error = '';

// 🔐 Step 1: Insert admin only if not exists
// $username = "admin";
// $password = "admin123";


$checkStmt = $mysqli->prepare("SELECT id FROM admins WHERE username = ?");
$checkStmt->bind_param("s", $username);
$checkStmt->execute();
$checkStmt->store_result();

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
        $_SESSION['admin_username'] = $loginUser; // Store username in session
        $_SESSION['LAST_ACTIVITY'] = time(); // 👈 Set activity for timeout tracking
        header('Location: dashboard');
        exit();
    } else {
        $error = "Invalid username or password";
    }
    $stmt->close();
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin Login – Virocon</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(to right, #6a11cb, #2575fc);
      height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      font-family: 'Segoe UI', sans-serif;
    }

    .login-card {
      border: none;
      border-radius: 20px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
      overflow: hidden;
      background: #ffffff;
    }

    .login-header {
      text-align: center;
      margin-bottom: 20px;
    }

    .login-header img {
      width: 60px;
      margin-bottom: 10px;
    }

    .login-header h4 {
      font-weight: bold;
      color: #333;
    }

    .form-label {
      font-weight: 600;
    }

    .btn-primary {
      background-color: #2575fc;
      border: none;
      font-weight: bold;
    }

    .btn-primary:hover {
      background-color: #1a5edb;
    }

    .footer {
      text-align: center;
      font-size: 0.85rem;
      color: #fff;
      margin-top: 20px;
    }

    .alert {
      font-size: 0.9rem;
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-5 col-lg-4">
        <div class="card login-card p-4">
          <div class="login-header">
            <img src="https://cdn-icons-png.flaticon.com/512/3135/3135715.png" alt="Admin Icon">
            <h4>Virocon Admin Login</h4>
          </div>
          <?php if ($error): ?>
            <div class="alert alert-danger py-1"><?= htmlspecialchars($error) ?></div>
          <?php endif; ?>
          <form method="POST" novalidate>
            <div class="mb-3">
              <label class="form-label">Username</label>
              <input type="text" name="username" class="form-control" placeholder="Enter admin username" required autofocus>
            </div>
            <div class="mb-3">
              <label class="form-label">Password</label>
              <input type="password" name="password" class="form-control" placeholder="Enter password" required>
            </div>
            <div class="d-grid">
              <button class="btn btn-primary" type="submit">Login</button>
            </div>
          </form>
        </div>
        <div class="footer mt-3">
          © <?= date("Y") ?> Virocon Admin Portal
        </div>
      </div>
    </div>
  </div>
</body>
</html>
