<?php
session_start();
include 'db_connect.php';

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php"); // Redirect to login or homepage
    exit();
}


$logged_in_id = $_SESSION['user_id'];
$role = $_SESSION['role'];

// Admin can view any profile using ?id=USER_ID
if ($role === 'Admin' && isset($_GET['id'])) {
    $user_id = intval($_GET['id']);
} else {
    // Normal users can only view their own profile
    $user_id = $logged_in_id;
}

// Fetch user info
$stmt = $conn->prepare("SELECT * FROM users WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

if (!$user) {
    die("User not found.");
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Profile - VolunteerConnect</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f9f9f9; margin: 0; padding: 0; }
        .container { max-width: 600px; margin: 50px auto; background: #fff; padding: 30px; border-radius: 12px; box-shadow: 0 8px 20px rgba(0,0,0,0.1); }
        h1 { text-align: center; color: #2c7be5; margin-bottom: 20px; }
        form { display: flex; flex-direction: column; }
        label { margin-top: 15px; font-weight: bold; }
        input { padding: 10px; margin-top: 5px; border-radius: 6px; border: 1px solid #ccc; }
        .btn { margin-top: 20px; padding: 10px; border: none; border-radius: 6px; background-color: #2c7be5; color: #fff; cursor: pointer; font-weight: bold; }
        .btn:hover { background-color: #1a5bb8; }
        .profile-pic { width: 100px; height: 100px; border-radius: 50%; object-fit: cover; margin: 0 auto 20px; display: block; }
        .message { text-align: center; margin-top: 15px; color: green; }
    </style>
</head>
<body>
    <div class="container">
        <h1>My Profile</h1>

        <?php if ($user['profile_pic']): ?>
            <img src="<?= htmlspecialchars($user['profile_pic']); ?>" alt="Profile Picture" class="profile-pic">
        <?php endif; ?>

<form method="POST" action="">
    <label>Username</label>
    <input type="text" value="<?= htmlspecialchars($user['username']); ?>" disabled>

    <label>Email</label>
    <input type="email" name="email" value="<?= htmlspecialchars($user['email']); ?>" disabled>

    <label>Phone</label>
    <input type="text" name="phone" value="<?= htmlspecialchars($user['phone']); ?>" disabled>

    <?php if ($user['role'] === 'Volunteer'): ?>
        <label>NIC</label>
        <input type="text" value="<?= htmlspecialchars($user['nic']); ?>" disabled>
    <?php elseif ($user['role'] === 'Organization'): ?>
        <label>Registration Number</label>
        <input type="text" value="<?= htmlspecialchars($user['registration_number']); ?>" disabled>
    <?php endif; ?>

    <label>Role</label>
    <input type="text" value="<?= htmlspecialchars($user['role']); ?>" disabled>
</form>


</body>
</html>
