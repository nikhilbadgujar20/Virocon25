<?php
require_once 'auth.php'; // ✅ session/auth check
require_once 'db.php';

$id = $_GET['registration_number'] ?? '';
if (!$id) {
    http_response_code(400);
    exit('Missing registration number.');
}

// Fetch single row from `register`
$stmt = $mysqli->prepare("SELECT * FROM register WHERE registration_number = ?");
$stmt->bind_param('s', $id);
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
  <title>Registration #<?= $reg['registration_number'] ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-4">
    <a href="dashboard.php" class="btn btn-secondary mb-3">← Back</a>
    <div class="card shadow-sm">
        <div class="card-header bg-info text-white">
            <h5 class="mb-0">Registration #<?= $reg['registration_number'] ?></h5>
        </div>
        <div class="card-body">

            <?php if ($reg['attempting_as'] === 'Presenter'): ?>
                <hr>
                <h5 class="mt-4">Presentation Details</h5>
                <dl class="row">
                    <dt class="col-md-3">Abstract Title</dt>
                    <dd class="col-md-9"><?= htmlspecialchars($reg['abstract_title'] ?? 'N/A') ?></dd>

                    <dt class="col-md-3">Authors</dt>
                    <dd class="col-md-9"><?= htmlspecialchars($reg['authors'] ?? 'N/A') ?></dd>

                    <dt class="col-md-3">Abstract Text</dt>
                    <dd class="col-md-9"><?= nl2br(htmlspecialchars($reg['abstract_text'] ?? '')) ?></dd>

                    <dt class="col-md-3">Presentation File</dt>
                    <dd class="col-md-9">
                        <?php
                        $filePath = $reg['file_path'];
                        $fullPath = __DIR__ . '/' . $filePath;
                        ?>
                        <?php if (!empty($filePath) && file_exists($fullPath)): ?>
                            <a href="<?= htmlspecialchars($filePath) ?>" target="_blank" class="btn btn-sm btn-outline-primary me-2">View File</a>
                            <a href="<?= htmlspecialchars($filePath) ?>" download class="btn btn-sm btn-outline-success">Download</a>
                        <?php else: ?>
                            <span class="text-muted">Not uploaded</span>
                        <?php endif; ?>
                    </dd>
                </dl>
            <?php endif; ?>

            <hr>
            <h5>Registrant Details</h5>
            <dl class="row">
                <?php
                $fields = [
                    'Title' => 'title', 'Gender' => 'gender', 'First Name' => 'first_name',
                    'Last Name' => 'last_name', 'Organization' => 'organization',
                    'Delegate Type' => 'delegate_type', 'Nature of Delegate' => 'nature_of_delegate',
                    'Postal Address' => 'postal_address', 'City' => 'city', 'Pin Code' => 'pin_code',
                    'State' => 'state', 'Country' => 'country', 'Telephone No' => 'telephone_no',
                    'Mobile No' => 'mobile_no', 'Email' => 'email',
                    'No. of Accompanying Persons' => 'no_of_accompanying_persons',
                    'Payment Amount' => 'payment_amount'
                ];

                foreach ($fields as $label => $key) {
                    echo "<dt class='col-md-3'>{$label}</dt>";
                    echo "<dd class='col-md-9'>" . ($key === 'payment_amount' ? '₹' . number_format($reg[$key], 2) : htmlspecialchars($reg[$key])) . "</dd>";
                }
                ?>
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
                <a href="dashboard.php" class="btn btn-sm btn-info w-30 mb-1">Back</a>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
    $(document).on('click', '.act-btn', function () {
        const id = $(this).data('id');
        const action = $(this).data('action');
        if (!confirm('Are you sure to ' + action + ' this registration?')) return;
        $.post('action.php', { registration_number: id, action }, function (res) {
            if (res.status === 'ok') {
                location.reload();
            } else {
                alert(res.error || 'Failed');
            }
        }, 'json');
    });
</script>
</body>
</html>
