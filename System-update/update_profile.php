<?php
session_start();
include 'db_connect.php';

// Only allow logged-in users
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch current user data
$stmt = $conn->prepare("SELECT * FROM users WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

if (!$user) {
    die("User not found.");
}

// Handle profile update (optional)
$update_msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $nic = trim($_POST['nic']);
    $phone = trim($_POST['phone']);

    // Handle profile picture upload
    if (!empty($_FILES['profile_pic']['name'])) {
        $uploads_dir = 'uploads/';
        if (!is_dir($uploads_dir)) mkdir($uploads_dir, 0755, true); // create if missing
        $file_name = time() . '_' . basename($_FILES['profile_pic']['name']);
        $target_path = $uploads_dir . $file_name;
        if (move_uploaded_file($_FILES['profile_pic']['tmp_name'], $target_path)) {
            $profile_pic = $file_name;
        } else {
            $profile_pic = $user['profile_pic']; // keep old if upload fails
        }
    } else {
        $profile_pic = $user['profile_pic']; // keep old if no new upload
    }

    $updateStmt = $conn->prepare("UPDATE users SET username=?, nic=?, phone=?, profile_pic=? WHERE user_id=?");
    $updateStmt->bind_param("ssssi", $username, $nic, $phone, $profile_pic, $user_id);

    if ($updateStmt->execute()) {
        $update_msg = "Profile updated successfully!";
        $user['username'] = $username;
        $user['nic'] = $nic;
        $user['phone'] = $phone;
        $user['profile_pic'] = $profile_pic;
    } else {
        $update_msg = "Failed to update profile.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>My Profile - VolunteerConnect</title>
<style>
    body { font-family: Arial, sans-serif; background: #f9f9f9; margin: 0; padding: 0; }
    .container { max-width: 500px; margin: 50px auto; background: #fff; padding: 30px; border-radius: 12px; box-shadow: 0 8px 20px rgba(0,0,0,0.1); }
    h1 { text-align: center; color: #2c7be5; margin-bottom: 20px; }
    .profile-pic { width: 120px; height: 120px; border-radius: 50%; object-fit: cover; display: block; margin: 0 auto 20px; border: 2px solid #ddd; }
    .profile-info { margin-bottom: 15px; }
    .profile-info label { font-weight: bold; display: block; margin-bottom: 5px; }
    .profile-info input { width: 100%; padding: 10px; border-radius: 6px; border: 1px solid #ccc; margin-bottom: 10px; }
    .message { text-align: center; margin-top: 15px; color: green; }
    button { width: 100%; padding: 12px; border-radius: 6px; border: none; background-color: #2c7be5; color: #fff; font-weight: bold; cursor: pointer; }
    button:hover { background-color: #1a5bb8; }
</style>
</head>
<body>

<div class="container">
    <h1>My Profile</h1>

    <?php
    $profilePic = !empty($user['profile_pic']) && file_exists('uploads/'.$user['profile_pic'])
                  ? 'uploads/' . $user['profile_pic']
                  : 'uploads/default.jpg';
    ?>
    <img src="<?= htmlspecialchars($profilePic) ?>" alt="Profile Picture" class="profile-pic">

    <form method="POST" enctype="multipart/form-data">
        <div class="profile-info">
            <label>Username</label>
            <input type="text" name="username" value="<?= htmlspecialchars($user['username']); ?>" required>
        </div>

        <div class="profile-info">
            <label>Email (readonly)</label>
            <input type="email" value="<?= htmlspecialchars($user['email']); ?>" disabled>
        </div>

        <div class="profile-info">
            <label>Phone</label>
            <input type="text" name="phone" value="<?= htmlspecialchars($user['phone']); ?>" required>
        </div>

        <div class="profile-info">
            <label>NIC</label>
            <input type="text" name="nic" value="<?= htmlspecialchars($user['nic']); ?>" required>
        </div>

        <div class="profile-info">
            <label>Profile Picture</label>
            <input type="file" name="profile_pic" accept=".jpg,.jpeg,.png">
        </div>

        <button type="submit">Update Profile</button>
    </form>

    <?php if ($update_msg): ?>
        <div class="message"><?= htmlspecialchars($update_msg); ?></div>
    <?php endif; ?>
</div>

</body>
</html>
