<?php
session_start();
include 'db_connect.php'; // optional, or your connection code

if (!isset($_SESSION['user_id'])) {
    die("You must be logged in to submit a request.");
}
$org_id = $_SESSION['user_id'];

// Get form values
$title    = isset($_POST['reqTitle']) ? trim($_POST['reqTitle']) : "";
$desc     = isset($_POST['reqDesc']) ? trim($_POST['reqDesc']) : "";
$category = isset($_POST['reqCategory']) ? trim($_POST['reqCategory']) : "";
$count    = isset($_POST['reqCount']) ? intval($_POST['reqCount']) : 0;
$date     = isset($_POST['reqDate']) ? $_POST['reqDate'] : "";

// File upload (optional)
$filePath = NULL;
if (isset($_FILES['reqFile']) && $_FILES['reqFile']['error'] == 0) {
    $uploadDir = "uploads/";
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }
    $fileName = time() . "_" . basename($_FILES['reqFile']['name']);
    $filePath = $uploadDir . $fileName;
    move_uploaded_file($_FILES['reqFile']['tmp_name'], $filePath);
}

// Insert into volunteer_requests table
$sql = "INSERT INTO volunteer_requests (organization_id, title, description, category, volunteers_needed, event_datetime, file_path) 
        VALUES (?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("isssiss", $org_id, $title, $desc, $category, $count, $date, $filePath);

if ($stmt->execute()) {
    echo "<p style='color:green;'>Your volunteer request has been submitted successfully.</p>";
} else {
    echo "<p style='color:red;'>Error: " . $stmt->error . "</p>";
}

$stmt->close();
$conn->close();
?>
