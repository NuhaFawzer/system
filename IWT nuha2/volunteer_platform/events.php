<?php
require_once 'db.php';
require_once 'auth.php';
require_login();
include 'header.php';

$uid = current_user()['id'];
?>
<div class="card">
  <h2>Events</h2>
  <p>Sign up for events that match your skills and availability.</p>
  <?php
    $events = $conn->query("
      SELECT e.*,
             EXISTS(SELECT 1 FROM assignments a WHERE a.event_id=e.id AND a.user_id={$uid}) AS joined,
             (SELECT COUNT(*) FROM assignments a WHERE a.event_id=e.id) AS signed_up
      FROM events e
      ORDER BY e.event_time ASC
    ");
    if ($events && $events->num_rows > 0):
      while ($e = $events->fetch_assoc()):
  ?>
  <div id="event-<?php echo $e['id']; ?>" class="card">
    <h3><?php echo htmlspecialchars($e['title']); ?></h3>
    <p><strong>When:</strong> <?php echo htmlspecialchars($e['event_time']); ?> |
       <strong>Where:</strong> <?php echo htmlspecialchars($e['location']); ?></p>
    <p><strong>Required skills:</strong> <?php echo htmlspecialchars($e['required_skills']); ?></p>
    <p><?php echo htmlspecialchars($e['description']); ?></p>
    <p><strong>Slots:</strong> <?php echo (int)$e['slots']; ?> |
       <strong>Signed up:</strong> <?php echo (int)$e['signed_up']; ?></p>
    <?php if ($e['joined']): ?>
      <a class="btn secondary" href="signup_event.php?action=cancel&event_id=<?php echo $e['id']; ?>">Cancel Sign-up</a>
    <?php elseif ((int)$e['signed_up'] < (int)$e['slots']): ?>
      <a class="btn" href="signup_event.php?action=join&event_id=<?php echo $e['id']; ?>">Sign Up</a>
    <?php else: ?>
      <em>Event is full</em>
    <?php endif; ?>
  </div>
  <?php
      endwhile;
    else:
      echo "<p>No events available.</p>";
    endif;
  ?>
</div>

<div class="card">
  <h3>Your Sign-ups</h3>
  <?php
    $mine = $conn->query("
      SELECT e.id, e.title, e.event_time, e.location
      FROM assignments a
      JOIN events e ON e.id = a.event_id
      WHERE a.user_id = {$uid}
      ORDER BY e.event_time ASC
    ");
    if ($mine && $mine->num_rows > 0):
  ?>
    <table class="table">
      <tr><th>Title</th><th>When</th><th>Where</th><th>Action</th></tr>
      <?php while ($m = $mine->fetch_assoc()): ?>
        <tr>
          <td><?php echo htmlspecialchars($m['title']); ?></td>
          <td><?php echo htmlspecialchars($m['event_time']); ?></td>
          <td><?php echo htmlspecialchars($m['location']); ?></td>
          <td><a class="btn secondary" href="signup_event.php?action=cancel&event_id=<?php echo $m['id']; ?>">Cancel</a></td>
        </tr>
      <?php endwhile; ?>
    </table>
  <?php else: ?>
    <p>You haven't signed up for any events yet.</p>
  <?php endif; ?>
</div>

<?php include 'footer.php'; ?>
