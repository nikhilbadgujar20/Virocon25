<?php
// SBI decryption key
$ENCRYPTION_KEY = "YOUR_SECRET_KEY";

// Placeholder decrypt function
function decrypt($data, $key) {
    // Replace with SBI’s real decrypt logic
    return base64_decode($data); // TEMPORARY
}

$response = $_POST['encResponse'] ?? '';

if (!$response) {
    echo "<h4 class='text-danger'>Invalid response</h4>";
    exit;
}

$decrypted = decrypt($response, $ENCRYPTION_KEY);
parse_str($decrypted, $result);

// Now you can access response fields
$status = $result['order_status'] ?? 'Unknown';
$reg = $result['merchant_param1'] ?? '';
$transaction_id = $result['tracking_id'] ?? '';

if ($status === 'Success') {
    // ✅ Mark user as paid in DB
    include 'conn.php';
    $update = "UPDATE registrations SET payment_status = 'Paid', transaction_id = '$transaction_id' WHERE registration_number = '$reg'";
    mysqli_query($conn, $update);
    echo "<h3 class='text-success text-center mt-5'>Payment Successful</h3>";
} else {
    echo "<h3 class='text-danger text-center mt-5'>Payment Failed or Cancelled</h3>";
}
?>
