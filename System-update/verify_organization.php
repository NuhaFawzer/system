<?php
include 'db_connect.php';

$user_id = 5; // organization ID
$is_verified = 1;

$stmt = $conn->prepare("UPDATE users SET is_verified = ? WHERE user_id = ?");
$stmt->bind_param("ii", $is_verified, $user_id);

if($stmt->execute()){
    echo "Organization verified successfully!";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
