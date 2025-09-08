<?php
session_start();

// If not logged in or not admin
if (!isset($_SESSION['user_id']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'Admin') {
    // Redirect to login page
    $_SESSION['login_error'] = "You must log in as Admin to access this page.";
    header("Location: index.php"); // index.php has the login modal
    exit;
}
?>

<?php
// Database connection
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "volunteer_connect_db";

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

// Handle deletion
if (isset($_GET['delete_user_id'])) {
    $delete_id = intval($_GET['delete_user_id']);
    $conn->query("DELETE FROM users WHERE user_id = $delete_id");
    header("Location: admin.php"); // Refresh page after deletion
    exit();
}

// Approve organization
if (isset($_GET['approve_id'])) {
    $id = intval($_GET['approve_id']);
    $conn->query("UPDATE users SET status='Approved' WHERE user_id=$id");
    header("Location: admin.php");
    exit();
}

// Reject organization
if (isset($_GET['reject_id'])) {
    $id = intval($_GET['reject_id']);
    $conn->query("UPDATE users SET status='Rejected' WHERE user_id=$id");
    header("Location: admin.php");
    exit();
}
$pendingOrgs = $conn->query("SELECT * FROM users WHERE role='Organization' AND status='Pending' ORDER BY created_at DESC");

// Fetch volunteers
$volunteers = $conn->query("SELECT * FROM users WHERE role='Volunteer' ORDER BY created_at DESC");

// Fetch organizations
$organizations = $conn->query("SELECT * FROM users WHERE role='Organization' ORDER BY created_at DESC");

// Fetch new signups
$newSignups = $conn->query("SELECT * FROM users WHERE is_new=1 ORDER BY created_at DESC");

// Mark all new users as seen
$conn->query("UPDATE users SET is_new=0 WHERE is_new=1");
$totalVolunteers = $conn->query("SELECT COUNT(*) as count FROM users WHERE role='Volunteer'")->fetch_assoc()['count'];
$totalOrgs = $conn->query("SELECT COUNT(*) as count FROM users WHERE role='Organization'")->fetch_assoc()['count'];
$totalEvents = $conn->query("SELECT COUNT(*) as count FROM events")->fetch_assoc()['count'];
$totalEventRegistrations = $conn->query("SELECT COUNT(*) as count FROM event_registrations")->fetch_assoc()['count'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Admin Dashboard</title>
<link rel="stylesheet" href="styles.css">
<style>
    .admin-header {
        background: white;
        padding: 15px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .admin-container { padding: 20px; }
    .card {
        background: white;
        border-radius: 8px;
        padding: 20px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.05);
        margin-bottom: 20px;
    }
    table { width: 100%; border-collapse: collapse; }
    table th, table td {
        padding: 10px;
        border-bottom: 1px solid #ddd;
        text-align: left;
    }
    .notification {
        background: #e7f3ff;
        border: 1px solid #b3d7ff;
        padding: 10px;
        margin-bottom: 15px;
        border-radius: 5px;
        color: #004085;
    }
    .logo img { height: 50px; }
    .btn { padding: 5px 10px; border-radius: 5px; text-decoration: none; }
    .btn-secondary { background: #3498db; color: #fff; }
    .btn-danger { background: #e74c3c; color: #fff; }
</style>
</head>
<body>

<header class="admin-header">
    <a href="index.php" class="logo"><img src="images/Logo.png" alt="VolunteerConnect Logo"></a>
    <h1>Admin Dashboard</h1>
    <a href="index.php" class="btn btn-secondary">Logout</a>
    <a href="reports.php" class="btn btn-primary">View Reports</a>
</header>

<div class="admin-container">
    <!-- Notifications -->
    <div id="notifications">
      <?php if ($newSignups->num_rows > 0): ?>
        <?php while($row = $newSignups->fetch_assoc()): ?>
          <div class="notification">
            New <?= htmlspecialchars($row['role']) ?> signed up: 
            <?= htmlspecialchars($row['username']) ?> (<?= htmlspecialchars($row['email']) ?>)
          </div>
        <?php endwhile; ?>
      <?php else: ?>
        <p style="color:red">No new signups.</p>
      <?php endif; ?>
    </div>

    <!-- Volunteers -->
    <div class="card">
      <h2>Volunteers</h2>
      <table>
        <thead>
          <tr>
            <th>Username</th>
            <th>Email</th>
            <th>NIC</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php while($row = $volunteers->fetch_assoc()): ?>
            <tr>
              <td><?= htmlspecialchars($row['username']) ?></td>
              <td><?= htmlspecialchars($row['email']) ?></td>
              <td><?= htmlspecialchars($row['nic']) ?></td>
              <td>
                <a href="profile.php?id=<?= $row['user_id'] ?>" class="btn btn-primary">View Profile</a>
                <a href="admin.php?delete_user_id=<?= $row['user_id'] ?>" 
                   onclick="return confirm('Are you sure you want to remove this user?');" 
                   class="btn btn-danger">Remove</a>
              </td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>

    <!-- Organizations -->
    <div class="card">
      <h2>Organizations</h2>
      <table>
        <thead>
          <tr>
            <th>Username</th>
            <th>Email</th>
            <th>NIC</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php while($row = $organizations->fetch_assoc()): ?>
            <tr>
              <td><?= htmlspecialchars($row['username']) ?></td>
              <td><?= htmlspecialchars($row['email']) ?></td>
              <td><?= htmlspecialchars($row['nic']) ?></td>
               <td>
                <a href="profile.php?id=<?= $row['user_id'] ?>" class="btn btn-primary">View Profile</a>
                <a href="admin.php?delete_user_id=<?= $row['user_id'] ?>" 
                   onclick="return confirm('Are you sure you want to remove this organization?');" 
                   class="btn btn-danger">Remove</a>
              </td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
    <div class="card">
  <h2>Pending Organizations</h2>
  <table>
    <thead>
      <tr>
        <th>Username</th>
        <th>Email</th>
        <th>registration_number</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      <?php while($row = $pendingOrgs->fetch_assoc()): ?>
        <tr>
          <td><?= htmlspecialchars($row['username']) ?></td>
          <td><?= htmlspecialchars($row['email']) ?></td>
          <td><?= htmlspecialchars($row['registration_number']) ?></td>
          <td>
            <a href="admin.php?approve_id=<?= $row['user_id'] ?>" class="btn btn-secondary">Approve</a>
            <a href="admin.php?reject_id=<?= $row['user_id'] ?>" class="btn btn-danger">Reject</a>
          </td>
        </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>
<div class="card">
    <h2>Platform Summary</h2>
    <ul>
        <li>Total Volunteers: <?= $totalVolunteers ?></li>
        <li>Total Organizations: <?= $totalOrgs ?></li>
        <li>Total Events: <?= $totalEvents ?></li>
        <li>Total Event Registrations: <?= $totalEventRegistrations ?></li>
    </ul>
</div>


</div>
</body>
</html>

<?php $conn->close(); ?>
