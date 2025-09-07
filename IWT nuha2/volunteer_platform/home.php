<?php
require_once 'db.php';
require_once 'auth.php';
require_login();
include 'header.php';

$role = current_user()['role'];
$name = htmlspecialchars(current_user()['name']);
?>
<div class="card">
  <h2>Welcome, <?php echo $name; ?>!</h2>
  <?php if ($role === 'admin'): ?>
    <p>This is your admin dashboard. From here, you can manage users, create events, and view reports.</p>
    <p><a class="btn" href="admin.php">Go to Admin Panel</a></p>
  <?php else: ?>
    <p>This is your volunteer dashboard. Browse events and sign up according to your skills and availability.</p>
    <p><a class="btn" href="events.php">Browse Events</a></p>
  <?php endif; ?>
</div>

<div class="card">
  <h3>Upcoming Events</h3>
  <?php
    $q = $conn->query("SELECT id, title, event_time, location FROM events ORDER BY event_time ASC LIMIT 5");
    if ($q && $q->num_rows > 0):
  ?>
    <table class="table">
      <tr><th>Title</th><th>When</th><th>Where</th><th>Action</th></tr>
      <?php while ($e = $q->fetch_assoc()): ?>
        <tr>
          <td><?php echo htmlspecialchars($e['title']); ?></td>
          <td><?php echo htmlspecialchars($e['event_time']); ?></td>
          <td><?php echo htmlspecialchars($e['location']); ?></td>
          <td><a class="btn secondary" href="events.php#event-<?php echo $e['id']; ?>">View</a></td>
        </tr>
      <?php endwhile; ?>
    </table>
  <?php else: ?>
    <p>No events yet.</p>
  <?php endif; ?>
</div>
<?php include 'footer.php'; ?>
