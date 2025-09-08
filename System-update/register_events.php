<?php
include 'db_connect.php';

$event_id = 1;
$volunteer_id = 2;

$stmt = $conn->prepare("INSERT INTO event_registrations (event_id, volunteer_id) VALUES (?, ?)");
$stmt->bind_param("ii", $event_id, $volunteer_id);

if($stmt->execute()){
    echo "Volunteer registered for event!";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
/*//method 2

<?php
include 'db_connect.php'; // your database connection

// Array of event registrations
$registrations = [
    ["event_id" => 1, "volunteer_id" => 2],
    ["event_id" => 2, "volunteer_id" => 2]
];

// Prepare statement
$stmt = $conn->prepare("
    INSERT INTO event_registrations (event_id, volunteer_id) 
    VALUES (?, ?)
");

foreach ($registrations as $reg) {
    $stmt->bind_param("ii", $reg['event_id'], $reg['volunteer_id']);
    $stmt->execute();
}

echo "Event registrations inserted successfully!";

$stmt->close();
$conn->close();
?>
*/
?>
