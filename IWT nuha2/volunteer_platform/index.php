<?php
require_once 'db.php';
require_once 'auth.php';

if (is_logged_in()) {
    header('Location: home.php');
    exit;
}
$msg = $_GET['msg'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $u = $conn->prepare("SELECT id, username, name, role, skills, availability, interests FROM users WHERE username=? AND password_hash=MD5(?)");
    $u->bind_param("ss", $username, $password);
    $u->execute();
    $res = $u->get_result();
    if ($row = $res->fetch_assoc()) {
        $_SESSION['user'] = $row;
        header('Location: home.php');
        exit;
    } else {
        $msg = 'Invalid credentials';
    }
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Login - Volunteer Coordination Platform</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
  <main class="container">
    <h2>Login</h2>
    <?php if ($msg): ?>
      <div class="notice error"><?php echo htmlspecialchars($msg); ?></div>
    <?php else: ?>
      <div class="notice">Use admin/admin or uoc/uoc</div>
    <?php endif; ?>
    <form method="post" class="card" style="max-width:400px;">
      <div class="form-row">
        <label>Username
          <input type="text" name="username" required>
        </label>
        <label>Password
          <input type="password" name="password" required>
        </label>
      </div>
      <button class="btn" type="submit">Login</button>
    </form>
    <p><a href="help.php">Need help?</a></p>
  </main>
</body>
</html>
