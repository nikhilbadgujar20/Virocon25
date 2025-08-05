<?php
// SBI config (replace later with real values)
$MERCHANT_ID = "YOUR_MERCHANT_ID";
$ENCRYPTION_KEY = "YOUR_SECRET_KEY";
$PAYMENT_URL = "https://www.sbiepay.com/secure/payment"; // Change to staging/production

// Get form values
$reg = $_POST['registration_number'];
$name = $_POST['full_name'];
$email = $_POST['email'];
$category = $_POST['category'];
$amount = $_POST['amount'];
$orderId = "ORD" . time(); // Unique ID
$returnUrl = "https://yourdomain.com/sbi-callback.php";

// Build the query string (order might be important, follow SBI docs)
$params = [
    "merchant_id" => $MERCHANT_ID,
    "order_id" => $orderId,
    "amount" => $amount,
    "currency" => "INR",
    "redirect_url" => $returnUrl,
    "cancel_url" => $returnUrl,
    "language" => "EN",
    "billing_name" => $name,
    "billing_email" => $email,
    "merchant_param1" => $reg
];

$queryString = http_build_query($params);

// Placeholder encryption (replace this with SBI's actual method)
function encrypt($data, $key) {
    // Example AES encryption (update when SBI provides)
    return base64_encode($data); // TEMPORARY
}

$encryptedRequest = encrypt($queryString, $ENCRYPTION_KEY);
?>

<form id="sbiForm" method="post" action="<?= $PAYMENT_URL ?>">
    <input type="hidden" name="encRequest" value="<?= $encryptedRequest ?>">
    <input type="hidden" name="merchant_id" value="<?= $MERCHANT_ID ?>">
</form>

<script>
    document.getElementById('sbiForm').submit();
</script>
