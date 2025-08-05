<?php
require_once 'db.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Submit Abstract</title>
</head>
<body>
<h2>Abstract Submission</h2>
<form action="submit-abstract.php" method="POST" enctype="multipart/form-data">
    <label>Registration Number:</label>
    <input type="text" name="registration_number" required><br>

    <label>Abstract Title (Max 25 words):</label>
    <input type="text" name="title" maxlength="250" required><br>

    <label>Authors (comma-separated):</label>
    <input type="text" name="authors" required><br>

    <label>Abstract Text (Max 250 words):</label>
    <textarea name="abstract_text" rows="6" required></textarea><br>

    <label>Upload File (PDF or DOCX, max 5MB):</label>
    <input type="file" name="abstract_file" accept=".pdf,.doc,.docx" required><br>

    <button type="submit">Submit Abstract</button>
</form>
</body>
</html>
