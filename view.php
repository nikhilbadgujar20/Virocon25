<?php // view.php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}

$timeout = 1800; // 30 minutes
if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY']) > $timeout) {
    session_unset();
    session_destroy();
    header("Location: login.php");
    exit();
}
$_SESSION['LAST_ACTIVITY'] = time();

require_once 'auth.php';
require_once 'db.php';

$id = (int)($_GET['id'] ?? 0);
$stmt = $mysqli->prepare("SELECT * FROM register WHERE id=?");
$stmt->bind_param('i', $id);
$stmt->execute();
$res = $stmt->get_result();
if (!$reg = $res->fetch_assoc()) {
    http_response_code(404);
    exit('Not found');
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registration #<?= $reg['id'] ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-4">
    <a href="dashboard.php" class="btn btn-secondary mb-3">← Back</a>
    <div class="card shadow-sm">
        <div class="card-header bg-info text-white">
            <h5 class="mb-0">Registration #<?= $reg['id'] ?></h5>
        </div>
        <div class="card-body">
            <dl class="row">
                <dt class="col-md-3">Title</dt><dd class="col-md-9"><?= htmlspecialchars($reg['title']) ?></dd>
                <dt class="col-md-3">Gender</dt><dd class="col-md-9"><?= htmlspecialchars($reg['gender']) ?></dd>
                <dt class="col-md-3">First Name</dt><dd class="col-md-9"><?= htmlspecialchars($reg['first_name']) ?></dd>
                <dt class="col-md-3">Last Name</dt><dd class="col-md-9"><?= htmlspecialchars($reg['last_name']) ?></dd>
                <dt class="col-md-3">Organization</dt><dd class="col-md-9"><?= htmlspecialchars($reg['organization']) ?></dd>
                <dt class="col-md-3">Delegate Type</dt><dd class="col-md-9"><?= htmlspecialchars($reg['delegate_type']) ?></dd>
                <dt class="col-md-3">Nature of Delegate</dt><dd class="col-md-9"><?= htmlspecialchars($reg['nature_of_delegate']) ?></dd>
                <dt class="col-md-3">Postal Address</dt><dd class="col-md-9"><?= htmlspecialchars($reg['postal_address']) ?></dd>
                <dt class="col-md-3">City</dt><dd class="col-md-9"><?= htmlspecialchars($reg['city']) ?></dd>
                <dt class="col-md-3">Pin Code</dt><dd class="col-md-9"><?= htmlspecialchars($reg['pin_code']) ?></dd>
                <dt class="col-md-3">State</dt><dd class="col-md-9"><?= htmlspecialchars($reg['state']) ?></dd>
                <dt class="col-md-3">Country</dt><dd class="col-md-9"><?= htmlspecialchars($reg['country']) ?></dd>
                <dt class="col-md-3">Telephone No</dt><dd class="col-md-9"><?= htmlspecialchars($reg['telephone_no']) ?></dd>
                <dt class="col-md-3">Mobile No</dt><dd class="col-md-9"><?= htmlspecialchars($reg['mobile_no']) ?></dd>
                <dt class="col-md-3">Email</dt><dd class="col-md-9"><?= htmlspecialchars($reg['email']) ?></dd>
                <dt class="col-md-3">No. of Accompanying Persons</dt><dd class="col-md-9"><?= $reg['no_of_accompanying_persons'] ?></dd>
                <dt class="col-md-3">Payment Amount</dt><dd class="col-md-9">₹<?= number_format($reg['payment_amount'], 2) ?></dd>
                <dt class="col-md-3">Status</dt>
                <dd class="col-md-9">
                    <span class="badge bg-<?= $reg['status'] === 'accepted' ? 'success' : ($reg['status'] === 'rejected' ? 'danger' : 'secondary') ?>">
                        <?= ucfirst($reg['status']) ?>
                    </span>
                </dd>
                <dt class="col-md-3">Submitted</dt>
                <dd class="col-md-9"><?= date('d M Y, H:i', strtotime($reg['created_at'])) ?></dd>
            </dl>
            <div class="mt-3">
                <a href="dashboard.php" class="btn btn-secondary">Back</a>
                <button data-id="<?= $reg['id'] ?>" data-action="accepted" class="btn btn-success act-btn">Accept</button>
                <button data-id="<?= $reg['id'] ?>" data-action="rejected" class="btn btn-danger act-btn">Reject</button>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
    window.addEventListener("beforeunload", function () {
    navigator.sendBeacon('logout.php');
});
    $(document).on('click', '.act-btn', function () {
        const id = $(this).data('id');
        const action = $(this).data('action');
        if (!confirm('Are you sure to ' + action + ' this registration?')) return;
        $.post('action.php', {id, action}, function (res) {
            if (res.status === 'ok') {
                location.reload();
            } else alert(res.error || 'Failed');
        }, 'json');
    });
</script>
</body>
</html>
