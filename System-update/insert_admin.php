<?php
include 'db_connect.php'; // your database connection

$username = "admin";
$email = "admin@volunteerconnect.org";
$password = password_hash("#admn721", PASSWORD_DEFAULT); // secure password hashing
$role = "Admin";
$nic = "200477300544";
$phone = "+94723959666";
$profile_pic = "images/adminprofile.png";

// Use INSERT ... ON DUPLICATE KEY UPDATE to avoid duplicates
$stmt = $conn->prepare("
    INSERT INTO users (username, email, password, role, nic, phone, profile_pic) 
    VALUES (?, ?, ?, ?, ?, ?, ?)
    ON DUPLICATE KEY UPDATE username=username
");

$stmt->bind_param("sssssss", $username, $email, $password, $role, $nic, $phone, $profile_pic);

if ($stmt->execute()) {
    echo "Admin user inserted successfully!";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
