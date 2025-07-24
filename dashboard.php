<?php

  session_start();
  require_once 'auth.php';

  // ✅ DB connection
  $mysqli = new mysqli("localhost", "root", "root", "virocon");

  // ✅ Check connection
  if ($mysqli->connect_errno) {
    die("❌ Failed to connect to MySQL: " . $mysqli->connect_error);
  }

  // ✅ Pagination setup
  $limit = 10;
  $page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int) $_GET['page'] : 1;
  $offset = ($page - 1) * $limit;

  // ✅ Total rows count
  $totalQuery = $mysqli->query("SELECT COUNT(*) AS total FROM register");
  $totalRows = $totalQuery->fetch_assoc()['total'];
  $totalPages = ceil($totalRows / $limit);

  // ✅ Fetch paginated rows
  $sql = "SELECT id, title, gender, first_name, last_name, organization, delegate_type,
        nature_of_delegate, postal_address, city, pin_code, state, country,
        telephone_no, mobile_no, email, no_of_accompanying_persons, payment_amount,
        status, created_at
        FROM register
        ORDER BY created_at ASC
        LIMIT $limit OFFSET $offset";

  $result = $mysqli->query($sql);

  // Fetch all relevant fields from register table
  $result = $mysqli->query("SELECT id, title, gender, first_name, last_name, organization, delegate_type,
        nature_of_delegate, postal_address, city, pin_code, state, country,
        telephone_no, mobile_no, email, no_of_accompanying_persons, payment_amount,
        status, created_at FROM register ORDER BY created_at DESC");


  // Check if user is logged in
  if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
      header("Location: login.php");
      exit;
  }

  // Auto logout after 1 hour of inactivity
  $timeout_duration = 3600;

  if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY']) > $timeout_duration) {
      // Session timed out
      session_unset();
      session_destroy();
      header("Location: login.php?timeout=1");
      exit;
  }

  $_SESSION['LAST_ACTIVITY'] = time(); // Update last activity timestamp
?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Dashboard – Virocon</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <style>
    /* .scroll-container {
      max-height: 500px;
      overflow-y: auto;
      overflow-x: auto;
      white-space: nowrap;
      border: 1px solid #ddd;
    }

    #regTable th,
    #regTable td {
      min-width: 120px;
      vertical-align: middle;
    } */
  </style>
</head>

<body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">Virocon Admin</a>
      <div class="d-flex"><a href="logout.php" class="btn btn-outline-light btn-sm">Logout</a></div>
    </div>
  </nav>

  <div class="container-fluid px-2 py-3">
    <h3 class="mb-3 text-center">Delegates Registered</h3>
    <hr>

    <div class="table-responsive">
      <table class="table table-bordered table-sm align-middle text-center" id="regTable">
        <thead class="table-light">
          <tr>
            <th>#</th>
            <th>Title</th>
            <th>Name</th>
            <th>Gender</th>
            <th>Organization</th>
            <th>Delegate Type</th>
            <th>Nature of Delegate</th>
            <th>Postal Address</th>
            <th>City</th>
            <th>Pin Code</th>
            <th>State</th>
            <th>Country</th>
            <th>Telephone</th>
            <th>Mobile</th>
            <th>Email</th>
            <th>Accompanying Persons</th>
            <th>Amount</th>
            <th>Status</th>
            <th>Registered At</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($row = $result->fetch_assoc()): ?>
            <tr id="row-<?= $row['id'] ?>">
              <td><?= $row['id'] ?></td>
              <td><?= htmlspecialchars($row['title']) ?></td>
              <td><?= htmlspecialchars($row['first_name'] . ' ' . $row['last_name']) ?></td>
              <td><?= htmlspecialchars($row['gender']) ?></td>
              <td><?= htmlspecialchars($row['organization']) ?></td>
              <td><?= htmlspecialchars($row['delegate_type']) ?></td>
              <td><?= htmlspecialchars($row['nature_of_delegate']) ?></td>
              <td><?= htmlspecialchars($row['postal_address']) ?></td>
              <td><?= htmlspecialchars($row['city']) ?></td>
              <td><?= htmlspecialchars($row['pin_code']) ?></td>
              <td><?= htmlspecialchars($row['state']) ?></td>
              <td><?= htmlspecialchars($row['country']) ?></td>
              <td><?= htmlspecialchars($row['telephone_no']) ?></td>
              <td><?= htmlspecialchars($row['mobile_no']) ?></td>
              <td><?= htmlspecialchars($row['email']) ?></td>
              <td><?= (int)$row['no_of_accompanying_persons'] ?></td>
              <td>₹<?= number_format($row['payment_amount'], 2) ?></td>
              <td>
                <span class="badge bg-<?= $row['status'] === 'accepted' ? 'success' : ($row['status'] === 'rejected' ? 'danger' : 'secondary') ?>">
                  <?= ucfirst($row['status']) ?>
                </span>
              </td>
              <td><?= date('d M Y H:i', strtotime($row['created_at'])) ?></td>
              <td>
                <a href="view.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-info w-100 mb-1">View</a>
                <button data-id="<?= $row['id'] ?>" data-action="accepted" class="btn btn-sm btn-success act-btn w-100 mb-1">Accept</button>
                <button data-id="<?= $row['id'] ?>" data-action="rejected" class="btn btn-sm btn-danger act-btn w-100">Reject</button>
              </td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>

    <!-- Pagination UI -->
    <nav>
      <ul class="pagination justify-content-center">
        <?php if ($page > 1): ?>
          <li class="page-item"><a class="page-link" href="?page=<?= $page - 1 ?>">Previous</a></li>
        <?php endif; ?>

        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
          <li class="page-item <?= $i === $page ? 'active' : '' ?>">
            <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
          </li>
        <?php endfor; ?>

        <?php if ($page < $totalPages): ?>
          <li class="page-item"><a class="page-link" href="?page=<?= $page + 1 ?>">Next</a></li>
        <?php endif; ?>
      </ul>
    </nav>
  </div>

  <script>
    $(document).on('click', '.act-btn', function() {
      const id = $(this).data('id');
      const action = $(this).data('action');
      if (!confirm('Are you sure to ' + action + ' this registration?')) return;
      $.post('action.php', {
        id,
        action
      }, function(res) {
        if (res.status === 'ok') {
          const badge = $('#row-' + id + ' .badge');
          badge.removeClass('bg-secondary bg-success bg-danger')
            .addClass(action === 'accepted' ? 'bg-success' : 'bg-danger')
            .text(action.charAt(0).toUpperCase() + action.slice(1));
          alert('User notified via email.');
        } else alert(res.error || 'Failed');
      }, 'json');
    });
  </script>
</body>

</html>