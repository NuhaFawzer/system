<?php/*
include 'db_connect.php';

$organization_id = 4;
$title = "Community Beach Cleanup";
$description = "Help clean the beach and preserve marine life.";
$location = "Colombo Beach";
$event_date = "2025-09-30";

$stmt = $conn->prepare("INSERT INTO events (organization_id, title, description, location, event_date) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("issss", $organization_id, $title, $description, $location, $event_date);

if($stmt->execute()){
    echo "Event created successfully!";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
//method 2
<?php
include 'db_connect.php'; // your database connection

// Array of events
$events = [
    [
        "organization_id" => 4,  // organization1's user_id
        "title" => "Beach Cleanup",
        "description" => "Join us to clean the local beach.",
        "location" => "Colombo Beach",
        "event_date" => "2025-09-15"
    ],
    [
        "organization_id" => 4,
        "title" => "Tree Planting",
        "description" => "Help us plant trees in the community park.",
        "location" => "Galle Park",
        "event_date" => "2025-09-20"
    ]
];

// Prepare statement
$stmt = $conn->prepare("
    INSERT INTO events (organization_id, title, description, location, event_date) 
    VALUES (?, ?, ?, ?, ?)
");

foreach ($events as $event) {
    $stmt->bind_param(
        "issss",
        $event['organization_id'],
        $event['title'],
        $event['description'],
        $event['location'],
        $event['event_date']
    );
    $stmt->execute();
}

echo "Example events inserted successfully!";

$stmt->close();
$conn->close();
?>
?>*/

//<?php
// Database connection
include 'db_connect.php';
// Organization ID (must exist in users table)
$org_id = 1;

// Sample events
$events = [
    [
        "title" => "Central Park Cleanup",
        "description" => "Help keep our beloved Central Park clean and beautiful for everyone to enjoy.",
        "location" => "Central Park",
        "event_date" => "2025-09-20"
    ],
    [
        "title" => "Food Bank Assistance",
        "description" => "Help sort and package food donations for distribution to families in need.",
        "location" => "Local Food Bank",
        "event_date" => "2025-09-22"
    ],
    [
        "title" => "After School Tutoring",
        "description" => "Provide academic support and mentorship to elementary school students.",
        "location" => "Community Center",
        "event_date" => "2025-09-25"
    ]
];

// Prepare insert statement
$stmt = $conn->prepare("INSERT INTO events (organization_id, title, description, location, event_date) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("issss", $org_id, $title, $description, $location, $event_date);

foreach ($events as $event) {
    $title = $event['title'];
    $description = $event['description'];
    $location = $event['location'];
    $event_date = $event['event_date'];

    if ($stmt->execute()) {
        echo "✅ Event '$title' inserted successfully.<br>";
    } else {
        echo "❌ Error inserting '$title': " . $stmt->error . "<br>";
    }
}

$stmt->close();
$conn->close();
?>
