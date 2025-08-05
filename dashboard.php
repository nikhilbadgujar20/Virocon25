<link rel="stylesheet" href="css/dashboard.css">
<?php

// dashboard.php
require_once 'auth.php';

$mysqli = new mysqli("localhost", "root", "virocon2025", "virocon");
if ($mysqli->connect_errno) {
  die("❌ DB Connection Failed: " . $mysqli->connect_error);
}

$limit = 10;
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int) $_GET['page'] : 1;
$offset = ($page - 1) * $limit;

$statusFilter = isset($_GET['status']) ? $_GET['status'] : '';
$searchQuery = isset($_GET['search']) ? trim($_GET['search']) : '';

$allowedStatuses = ['accepted_oral', 'accepted_poster', 'rejected', 'pending'];
$whereSQL = '';

// Status filter
if ($statusFilter && in_array($statusFilter, $allowedStatuses)) {
  $whereSQL .= " status = '" . $mysqli->real_escape_string($statusFilter) . "'";
}

// Search filter
if (!empty($searchQuery)) {
  $escapedSearch = $mysqli->real_escape_string($searchQuery);
  $searchCondition = "(registration_number LIKE '%$escapedSearch%' OR CONCAT(first_name, ' ', last_name) LIKE '%$escapedSearch%' OR email LIKE '%$escapedSearch%')";
  $whereSQL .= ($whereSQL ? " AND " : "") . $searchCondition;
}

// Combine into WHERE clause
if (!empty($whereSQL)) {
  $whereSQL = " WHERE " . $whereSQL;
}

// Get total count
$totalQuery = $mysqli->query("SELECT COUNT(*) AS total FROM register $whereSQL");
$totalRows = $totalQuery->fetch_assoc()['total'];
$totalPages = ceil($totalRows / $limit);

// Fetch data
$sql = "SELECT * FROM register $whereSQL ORDER BY created_at DESC LIMIT $limit OFFSET $offset";
$result = $mysqli->query($sql);
?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Dashboard – Virocon</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>

<body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">Virocon Admin</a>
      <div class="d-flex"><a href="logout" class="btn btn-outline-light btn-sm">Logout</a></div>
    </div>
  </nav>

  <div class="container-fluid px-2 py-3">
    <h3 class="mb-3 text-center">Delegates Registered</h3>
    <hr>

    <!-- Filters -->
    <div class="row mb-3 align-items-end justify-content-between">
      <div class="col-md-4">
        <label for="status_filter" class="form-label">Filter by Status</label>
        <select id="status_filter" class="form-select">
          <option value="" <?= $statusFilter === '' ? 'selected' : '' ?>>All Statuses</option>
          <option value="pending" <?= $statusFilter === 'pending' ? 'selected' : '' ?>>Pending</option>
          <option value="accepted_oral" <?= $statusFilter === 'accepted_oral' ? 'selected' : '' ?>>Accepted as Oral</option>
          <option value="accepted_poster" <?= $statusFilter === 'accepted_poster' ? 'selected' : '' ?>>Accepted as Poster</option>
          <option value="rejected" <?= $statusFilter === 'rejected' ? 'selected' : '' ?>>Rejected</option>
        </select>
      </div>

      <div class="col-md-3 ms-auto d-flex justify-content-end gap-2">
        <input type="text" id="search" class="form-control" value="<?= htmlspecialchars($searchQuery) ?>" placeholder="Registration No, Name or Email" />
        <button class="btn btn-primary" id="filter_btn">Search</button>
      </div>
    </div>

    <div class="table-responsive">
      <table class="table table-bordered table-sm text-center align-middle table-striped-soft">
        <thead class="table-light">
          <tr>
            <th>Registration Number</th>
            <th>Name</th>
            <th>Gender</th>
            <th>Email</th>
            <th>Mobile</th>
            <th>Organization</th>
            <th>Delegate Type</th>
            <th>Status</th>
            <th>Registered</th>
            <th>Attempting As</th>
            <th>Payment Amount</th>
            <th>Abstract</th>
            <th>Accepted By</th>
            <th>Recommendation</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($row = $result->fetch_assoc()): ?>
            <tr id="row-<?= htmlspecialchars($row['registration_number']) ?>">
              <td><?= htmlspecialchars($row['registration_number']) ?></td>
              <td><?= htmlspecialchars($row['first_name'] . ' ' . $row['last_name']) ?></td>
              <td><?= htmlspecialchars($row['gender']) ?></td>
              <td><?= htmlspecialchars($row['email']) ?></td>
              <td><?= htmlspecialchars($row['mobile_no']) ?></td>
              <td><?= htmlspecialchars($row['organization']) ?></td>
              <td><?= htmlspecialchars($row['nature_of_delegate']) ?></td>
              <td>
                <?php
                $status = $row['status'];
                $badgeClass = 'bg-secondary';
                $statusText = 'Pending';
                if ($status === 'accepted_oral') {
                  $badgeClass = 'bg-success';
                  $statusText = 'Accepted (Oral)';
                } elseif ($status === 'accepted_poster') {
                  $badgeClass = 'bg-primary';
                  $statusText = 'Accepted (Poster)';
                } elseif ($status === 'rejected') {
                  $badgeClass = 'bg-danger';
                  $statusText = 'Rejected';
                }
                ?>
                <span class="badge <?= $badgeClass ?>"><?= $statusText ?></span>
              </td>
              <td><?= date('d M Y, H:i', strtotime($row['created_at'])) ?></td>
              <td><?= htmlspecialchars($row['attempting_as']) ?></td>
              <td><?= htmlspecialchars($row['payment_amount']) ?></td>
              <td>
                <?php
                $fullPath = __DIR__ . "/" . $row['file_path'];
                if (!empty($row['file_path']) && file_exists($fullPath)):
                ?>
                  <a href="<?= htmlspecialchars($row['file_path']) ?>" target="_blank" class="btn btn-sm btn-primary w-100 mb-1">View</a>
                  <a href="<?= htmlspecialchars($row['file_path']) ?>" download class="btn btn-sm btn-success w-100">Download</a>
                <?php else: ?>
                  <span class="text-muted">No File</span>
                <?php endif; ?>
              </td>
              <td>
                <?php
                $reviewedBy = htmlspecialchars($row['reviewed_by']);
                $reviewedAt = htmlspecialchars(date('d M Y, H:i', strtotime($row['reviewed_at'])));
                echo $reviewedBy ? "$reviewedBy<br><small class='text-muted'>$reviewedAt</small>" : 'Not Reviewed';
                ?>
              </td>
              <td>
                <?php
                $cert_fullPath = __DIR__ . "/" . $row['cert_file_path'];
                if (!empty($row['cert_file_path']) && file_exists($cert_fullPath)):
                ?>
                  <a href="<?= htmlspecialchars($row['cert_file_path']) ?>" target="_blank" class="btn btn-sm btn-primary w-100 mb-1">View</a>
                  <a href="<?= htmlspecialchars($row['cert_file_path']) ?>" download class="btn btn-sm btn-success w-100">Download</a>
                <?php else: ?>
                  <span class="text-muted">No File</span>
                <?php endif; ?>
              </td>
              <td>
                <a href="view?registration_number=<?= htmlspecialchars($row['registration_number']) ?>" class="btn btn-sm btn-info w-100 mb-1">Details</a>

                <?php if (in_array($status, ['accepted_oral', 'accepted_poster', 'rejected'])): ?>
                  <div class="fw-bold text-center text-<?= $status === 'rejected' ? 'danger' : 'success' ?>">
                    <?= $statusText ?>
                  </div>
                <?php else: ?>
                  <button class="btn btn-sm btn-success act-btn w-100 mb-1" data-id="<?= htmlspecialchars($row['registration_number']) ?>" data-action="accepted_oral">Accept as Oral</button>
                  <button class="btn btn-sm btn-primary act-btn w-100 mb-1" data-id="<?= htmlspecialchars($row['registration_number']) ?>" data-action="accepted_poster">Accept as Poster</button>
                  <button class="btn btn-sm btn-danger act-btn w-100" data-id="<?= htmlspecialchars($row['registration_number']) ?>" data-action="rejected">Reject</button>
                <?php endif; ?>
              </td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>


    <!-- Pagination -->
    <nav>
      <ul class="pagination justify-content-center mt-4">
        <?php if ($page > 1): ?>
          <li class="page-item"><a class="page-link" href="?page=<?= $page - 1 ?>&status=<?= urlencode($statusFilter) ?>&search=<?= urlencode($searchQuery) ?>">«</a></li>
        <?php endif; ?>
        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
          <li class="page-item <?= $i === $page ? 'active' : '' ?>">
            <a class="page-link" href="?page=<?= $i ?>&status=<?= urlencode($statusFilter) ?>&search=<?= urlencode($searchQuery) ?>"><?= $i ?></a>
          </li>
        <?php endfor; ?>
        <?php if ($page < $totalPages): ?>
          <li class="page-item"><a class="page-link" href="?page=<?= $page + 1 ?>&status=<?= urlencode($statusFilter) ?>&search=<?= urlencode($searchQuery) ?>">»</a></li>
        <?php endif; ?>
      </ul>
    </nav>

  </div>

  <script>
    $(document).ready(function() {
      // Filter change reload
      $('#status_filter').change(function() {
        const status = $(this).val();
        window.location.href = `?page=1&status=${encodeURIComponent(status)}`;
      });

      // Action buttons AJAX
      $(document).on('click', '.act-btn', function() {
        const registration_number = $(this).data('id');
        const action = $(this).data('action');
        if (!confirm(`Are you sure you want to ${action.replace('_', ' ')} this registration?`)) return;

        $.post('action.php', {
          registration_number: registration_number,
          action: action
        }, function(res) {
          if (res.status === 'ok') {
            // Update status badge
            const badge = $(`#row-${registration_number} .badge`);
            let badgeClass = 'bg-secondary';
            let statusText = 'Pending';
            if (action === 'accepted_oral') {
              badgeClass = 'bg-success';
              statusText = 'Accepted (Oral)';
            } else if (action === 'accepted_poster') {
              badgeClass = 'bg-primary';
              statusText = 'Accepted (Poster)';
            } else if (action === 'rejected') {
              badgeClass = 'bg-danger';
              statusText = 'Rejected';
            }
            badge.removeClass('bg-secondary bg-success bg-primary bg-danger').addClass(badgeClass).text(statusText);

            // Update action column
            const actionCell = $(`#row-${registration_number} td:last`);
            actionCell.html(`<div class="fw-bold text-center text-${action === 'rejected' ? 'danger' : 'success'}">${statusText}</div>`);

            location.reload(); // Reloads the entire page to reflect updated data

          } else {
            alert('❌ ' + (res.error || 'Failed to update.'));
          }
        }, 'json');
      });
    });

    // ------------------------Search Box------------------------------------
    $('#filter_btn').on('click', function() {
      const status = $('#status_filter').val();
      const search = $('#search').val().trim();

      // If search box is not empty, submit the search query and clear the input field.
      if (search) {
        const url = `?page=1&status=${encodeURIComponent(status)}&search=${encodeURIComponent(search)}`;
        window.location.href = url; // Redirect to the search results page
      } else {
        // If search is empty, you may want to reload the page without a search query (optional)
        const url = `?page=1&status=${encodeURIComponent(status)}`;
        window.location.href = url; // Redirect to the page without the search query
      }

      // Clear the search box after search
      $('#search').val('');
    });

    $('#search').keypress(function(e) {
      if (e.which === 13) {
        $('#filter_btn').click(); // Press Enter to trigger filter
      }
    });
  </script>
  <footer class="subfooter text-center">
    <div class="container d-flex justify-content-between flex-column flex-md-row align-items-center">
      <div>
        <span>VIROCON © 2025 All Rights Reserved</span>
      </div>
      <div class="admin-link">
        <a href="index">Home</a>
      </div>
    </div>
  </footer>


</body>

</html>