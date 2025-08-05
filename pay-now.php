<?php
include 'conn.php';

if (!isset($_GET['reg_no'])) {
    echo "<h4 class='text-center text-danger mt-5'>Invalid Access</h4>";
    exit;
}

$regNo = mysqli_real_escape_string($conn, $_GET['reg_no']);
$nameFromUrl = $_GET['name'] ?? '';

$query = "SELECT * FROM register WHERE registration_number = '$regNo'";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) == 0) {
    echo "<h4 class='text-center text-danger mt-5'>User not found</h4>";
    exit;
}

$user = mysqli_fetch_assoc($result);
$fullName = $user['first_name'] . ' ' . $user['last_name'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Pay Now</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to right, #6a11cb, #1a5edb);
        }
        .payment-box {
            max-width: 600px;
            margin: 50px auto;
            padding: 30px;
            background-color: #ffffff;
            border-radius: 15px;
            box-shadow: 0 0 25px rgba(0, 0, 0, 0.2);
        }
        .pay-btn {
            background-color: #033a46;
            color: white;
            font-size: 1.2rem;
            border-radius: 8px;
        }
        .pay-btn:hover {
            background-color: #045d6b;
        }
        .table tr th {
            background-color: #e3f2fd;
        }
        .table tr:nth-child(even) td {
            background-color: #f9f9f9;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="payment-box">
        <h3 class="text-center mb-4">Payment Details</h3>
        <table class="table">
            <tr><th>Name</th><td><?= htmlspecialchars($fullName) ?></td></tr>
            <tr><th>Email</th><td><?= htmlspecialchars($user['email']) ?></td></tr>
            <tr><th>Category</th><td><?= htmlspecialchars($user['delegate_type']) ?></td></tr>
            <tr><th>Amount</th><td>₹<?= htmlspecialchars($user['payment_amount']) ?></td></tr>
            <tr><th>Registration No.</th><td><?= htmlspecialchars($user['registration_number']) ?></td></tr>
        </table>

        <form method="post" action="sbi-request.php">
            <input type="hidden" name="registration_number" value="<?= $user['registration_number'] ?>">
            <input type="hidden" name="full_name" value="<?= $fullName ?>">
            <input type="hidden" name="email" value="<?= $user['email'] ?>">
            <input type="hidden" name="category" value="<?= $user['delegate_type'] ?>">
            <input type="hidden" name="amount" value="<?= $user['payment_amount'] ?>">
            <div class="text-center">
                <button type="submit" class="btn pay-btn px-5 py-2">Pay Now</button>
            </div>
        </form>
    </div>
</div>
</body>
</html>
