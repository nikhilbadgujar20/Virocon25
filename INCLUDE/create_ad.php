<?php
require_once 'conn.php'; // your DB connection
require_once 'db.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    $user = $_POST['user'] ?? '';

    if (!empty($username) && !empty($password) && !empty($user)) {
        $hash = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $mysqli->prepare("INSERT INTO admins (username, password_hash, user) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $hash, $user);

        if ($stmt->execute()) {
            $message = "✅ Admin inserted successfully.";
        } else {
            $message = "❌ Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        $message = "❗ All fields are required.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Create Admin</title>
</head>
<body>
  <h2>Register Admin</h2>
  <?php if (!empty($message)): ?>
    <p><strong><?php echo htmlspecialchars($message); ?></strong></p>
  <?php endif; ?>
  <form method="POST" action="">
    <label>Username:</label><br>
    <input type="text" name="username" required><br><br>

    <label>Password:</label><br>
    <input type="password" name="password" required><br><br>

    <label>Full Name:</label><br>
    <input type="text" name="user" required><br><br>

    <button type="submit">Create Admin</button>
  </form>
</body>
</html>
