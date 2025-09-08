<?php
include 'db_connect.php';

$event_id = 1;
$volunteer_id = 2;
$contribution = "5 hours volunteering";
$feedback = "Great experience, very organized!";

$stmt = $conn->prepare("INSERT INTO impact (event_id, volunteer_id, contribution, feedback) VALUES (?, ?, ?, ?)");
$stmt->bind_param("iiss", $event_id, $volunteer_id, $contribution, $feedback);

if($stmt->execute()){
    echo "Impact recorded successfully!";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
