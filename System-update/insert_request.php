<?php
include 'db_connect.php';

$organization_id = 1;
$title = "Park Tree Planting";
$description = "Need volunteers to plant trees in the city park.";
$category = "Environment";
$volunteers_needed = 10;
$event_datetime = "2025-10-05 09:00:00";
$file_path = "tree_planting.pdf";

$stmt = $conn->prepare("INSERT INTO volunteer_requests (organization_id, title, description, category, volunteers_needed, event_datetime, file_path) VALUES (?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("issssis", $organization_id, $title, $description, $category, $volunteers_needed, $event_datetime, $file_path);

if($stmt->execute()){
    echo "Volunteer request created!";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();

/*//method 2
<?php
include 'db_connect.php'; // your database connection

// Array of volunteer requests
$requests = [
    [
        "organization_id" => 4,
        "title" => "Food Drive Volunteers",
        "description" => "We need 10 volunteers to help distribute food.",
        "category" => "Community Service",
        "volunteers_needed" => 10,
        "event_datetime" => "2025-09-18 09:00:00",
        "file_path" => "food_drive.pdf"
    ],
    [
        "organization_id" => 4,
        "title" => "Community Park Cleanup",
        "description" => "Help us clean up the local park and make it beautiful.",
        "category" => "Environment",
        "volunteers_needed" => 15,
        "event_datetime" => "2025-09-15 09:00:00",
        "file_path" => "flyer.png"
    ],
    [
        "organization_id" => 4,
        "title" => "Literacy Program for Children",
        "description" => "Help children improve their reading and writing skills.",
        "category" => "Education",
        "volunteers_needed" => 10,
        "event_datetime" => "2025-10-01 10:00:00",
        "file_path" => "literacy_program.docx"
    ],
    [
        "organization_id" => 4,
        "title" => "Animal Shelter Support",
        "description" => "Assist at the local animal shelter by feeding, cleaning, and caring for animals.",
        "category" => "Animal Welfare",
        "volunteers_needed" => 12,
        "event_datetime" => "2025-09-25 09:00:00",
        "file_path" => "shelter_info.jpg"
    ]
];

// Prepare statement
$stmt = $conn->prepare("
    INSERT INTO volunteer_requests 
    (organization_id, title, description, category, volunteers_needed, event_datetime, file_path) 
    VALUES (?, ?, ?, ?, ?, ?, ?)
");

foreach ($requests as $req) {
    $stmt->bind_param(
        "isssiis",
        $req['organization_id'],
        $req['title'],
        $req['description'],
        $req['category'],
        $req['volunteers_needed'],
        $req['event_datetime'],
        $req['file_path']
    );
    $stmt->execute();
}

echo "Volunteer requests inserted successfully!";

$stmt->close();
$conn->close();
?>
*/
?>
