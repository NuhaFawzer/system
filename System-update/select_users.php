<?php
include 'db_connect.php';

$result = $conn->query("SELECT user_id, username, email, role, is_verified FROM users");

if($result->num_rows > 0){
    while($row = $result->fetch_assoc()){
        echo "ID: ".$row['user_id']." | Username: ".$row['username']." | Role: ".$row['role']." | Verified: ".$row['is_verified']."<br>";
    }
} else {
    echo "No users found.";
}

$conn->close();
?>
