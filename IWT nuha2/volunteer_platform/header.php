<?php
// header.php - top navigation
require_once 'auth.php';
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Volunteer Coordination Platform</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
<header class="topbar">
  <div class="brand">Volunteer Coordination Platform</div>
  <nav>
    <a href="home.php">Home</a>
    <a href="events.php">Events</a>
    <a href="functionalities.php">Functionalities</a>
    <a href="help.php">Help</a>
    <?php if (is_logged_in() && current_user()['role'] === 'admin'): ?>
      <a href="admin.php">Admin</a>
    <?php endif; ?>
    <?php if (is_logged_in()): ?>
      <span class="welcome">Hi, <?php echo htmlspecialchars(current_user()['name']); ?> (<?php echo current_user()['role']; ?>)</span>
      <a href="logout.php" class="btn-logout">Logout</a>
    <?php else: ?>
      <a href="index.php" class="btn-login">Login</a>
    <?php endif; ?>
  </nav>
</header>
<main class="container">
