<?php
session_start();
include 'db_connect.php';

// Only allow logged-in volunteers
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Volunteer') {
    header("Location: index.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Handle profile deletion
if (isset($_POST['deleteProfile'])) {
    $sqlDelete = "DELETE FROM users WHERE user_id=$user_id";
    if (mysqli_query($conn, $sqlDelete)) {
        session_destroy(); // log out user
        header("Location: index.php"); // redirect to homepage/login
        exit();
    } else {
        echo "<script>alert('Failed to delete profile. Please try again.');</script>";
    }
}

// Fetch current user data
$sql = "SELECT * FROM users WHERE user_id = $user_id";
$result = mysqli_query($conn, $sql);
$user = mysqli_fetch_assoc($result);

// Handle profile update
if (isset($_POST['updateProfile'])) {
    $username = trim($_POST['username']);
    $nic = trim($_POST['nic']);
    $phone = trim($_POST['phone']);

    if (!empty($_FILES['profile_pic']['name'])) {
        $file_name = time() . '_' . $_FILES['profile_pic']['name'];
        move_uploaded_file($_FILES['profile_pic']['tmp_name'], 'uploads/' . $file_name);
    } else {
        $file_name = $user['profile_pic'];
    }

    $sqlUpdate = "UPDATE users SET username='$username', nic='$nic', phone='$phone', profile_pic='$file_name' WHERE user_id=$user_id";
    if (mysqli_query($conn, $sqlUpdate)) {
        echo "<script>alert('Profile updated successfully!');</script>";
        $result = mysqli_query($conn, $sql);
        $user = mysqli_fetch_assoc($result);
    } else {
        echo "<script>alert('Update failed. Please try again.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Manage Profile</title>
<link rel="stylesheet" href="styles.css">
</head>
<body>
<div class="form-container">
    <!-- Delete Button -->
    <form method="POST" style="display:inline;">
        <button type="submit" name="deleteProfile" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete your profile? This cannot be undone.')">
            Delete Profile
        </button>
    </form>

</script>
</body>
</html>
