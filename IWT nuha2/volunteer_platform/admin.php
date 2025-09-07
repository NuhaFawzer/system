<?php
require_once 'db.php';
require_once 'auth.php';
require_role('admin');
include 'header.php';

$tab = $_GET['tab'] ?? 'users';
$msg = $_GET['msg'] ?? '';

// Handle create user (admin can add volunteer or organization)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create_user'])) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $name     = trim($_POST['name']);
    $user_type= $_POST['user_type'];
    $skills   = trim($_POST['skills']);
    $availability = trim($_POST['availability']);
    $interests = trim($_POST['interests']);
    $stmt = $conn->prepare("INSERT INTO users (username, password_hash, name, role, user_type, skills, availability, interests) VALUES (?, MD5(?), ?, 'user', ?, ?, ?, ?)");
    $stmt->bind_param('sssssss', $username, $password, $name, $user_type, $skills, $availability, $interests);
    if ($stmt->execute()) $msg = 'User created';
    else $msg = 'Error creating user: ' . $conn->error;
    $tab = 'users';
}

// Handle delete user
if (isset($_GET['delete_user'])) {
    $id = intval($_GET['delete_user']);
    if ($id != current_user()['id']) {
        $conn->query("DELETE FROM users WHERE id={$id}");
        $msg = 'User deleted';
    } else {
        $msg = 'Cannot delete yourself';
    }
    $tab = 'users';
}

?>
<div class="card">
  <h2>Admin Panel</h2>
  <?php if ($msg): ?><div class="notice"><?php echo htmlspecialchars($msg); ?></div><?php endif; ?>
  <div style="margin-bottom:12px;">
    <a class="btn <?php echo $tab==='users'?'':'secondary'; ?>" href="?tab=users">Users</a>
    <a class="btn <?php echo $tab==='reports'?'':'secondary'; ?>" href="?tab=reports">Reports</a>
  </div>

  <?php if ($tab === 'users'): ?>
    <h3>Create User</h3>
    <form method="post" class="card">
      <input type="hidden" name="create_user" value="1">
      <div class="form-row">
        <label>Username
          <input type="text" name="username" required>
        </label>
        <label>Password
          <input type="password" name="password" required>
        </label>
      </div>
      <div class="form-row">
        <label>Name
          <input type="text" name="name" required>
        </label>
        <label>User Type
          <select name="user_type">
            <option value="volunteer">Volunteer</option>
            <option value="organization">Organization</option>
          </select>
        </label>
      </div>
      <div class="form-row">
        <label>Skills
          <input type="text" name="skills">
        </label>
        <label>Availability
          <input type="text" name="availability">
        </label>
      </div>
      <div class="form-row">
        <label>Interests
          <input type="text" name="interests">
        </label>
      </div>
      <button class="btn" type="submit">Create</button>
    </form>

    <h3>All Users</h3>
    <?php
      $users = $conn->query("SELECT id, username, name, user_type FROM users ORDER BY id DESC");
      if ($users && $users->num_rows > 0):
    ?>
      <table class="table">
        <tr><th>ID</th><th>Username</th><th>Name</th><th>User Type</th><th>Actions</th></tr>
        <?php while ($u = $users->fetch_assoc()): ?>
          <tr>
            <td><?php echo $u['id']; ?></td>
            <td><?php echo htmlspecialchars($u['username']); ?></td>
            <td><?php echo htmlspecialchars($u['name']); ?></td>
            <td><?php echo htmlspecialchars($u['user_type']); ?></td>
            <td>
              <?php if ($u['id'] != current_user()['id']): ?>
                <a class="btn secondary" href="?delete_user=<?php echo $u['id']; ?>" onclick="return confirm('Delete user?');">Delete</a>
              <?php else: ?>
                <em>current</em>
              <?php endif; ?>
            </td>
          </tr>
        <?php endwhile; ?>
      </table>
    <?php else: ?>
      <p>No users yet.</p>
    <?php endif; ?>

  <?php elseif ($tab === 'reports'): ?>
    <h3>Reports (All Events)</h3>
    <?php
      $r = $conn->query("
        SELECT e.id, e.title, u.name AS org_name, COUNT(a.user_id) AS volunteers
        FROM events e
        JOIN users u ON e.created_by=u.id
        LEFT JOIN assignments a ON a.event_id=e.id
        GROUP BY e.id, e.title, u.name
        ORDER BY volunteers DESC
      ");
      if ($r && $r->num_rows > 0):
    ?>
      <table class="table">
        <tr><th>Event</th><th>Organization</th><th>Volunteers</th></tr>
        <?php while ($row = $r->fetch_assoc()): ?>
          <tr>
            <td><?php echo htmlspecialchars($row['title']); ?></td>
            <td><?php echo htmlspecialchars($row['org_name']); ?></td>
            <td><?php echo (int)$row['volunteers']; ?></td>
          </tr>
        <?php endwhile; ?>
      </table>
    <?php else: ?>
      <p>No data yet.</p>
    <?php endif; ?>
  <?php endif; ?>
</div>
<?php include 'footer.php'; ?>
