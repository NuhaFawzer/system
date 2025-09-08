<?php
session_start();

// Only volunteers
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Volunteer') {
    header("Location: index.php");
    exit();
}

if (!isset($_POST['event_id'])) {
    die("Invalid event ID.");
}

$user_id = $_SESSION['user_id'];
$event_id = intval($_POST['event_id']);

// Database connection
$conn = new mysqli("localhost", "root", "", "volunteer_connect_db");
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

// Validate event exists
$stmtCheckEvent = $conn->prepare("SELECT event_id FROM events WHERE event_id = ?");
$stmtCheckEvent->bind_param("i", $event_id);
$stmtCheckEvent->execute();
if ($stmtCheckEvent->get_result()->num_rows === 0) {
    die("❌ Event does not exist.");
}

// Validate volunteer exists (optional if session user guaranteed)
$stmtCheckUser = $conn->prepare("SELECT user_id FROM users WHERE user_id = ?");
$stmtCheckUser->bind_param("i", $user_id);
$stmtCheckUser->execute();
if ($stmtCheckUser->get_result()->num_rows === 0) {
    die("❌ Volunteer does not exist.");
}

// Check if already registered
$stmt = $conn->prepare("SELECT * FROM event_registrations WHERE event_id=? AND volunteer_id=?");
$stmt->bind_param("ii", $event_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo "<p>❌ You are already registered for this event.</p>";
    echo "<a href='volunteer.php'>Back to Events</a>";
    exit();
}
$stmt->close();

// Register volunteer
$stmt = $conn->prepare("INSERT INTO event_registrations (event_id, volunteer_id) VALUES (?, ?)");
$stmt->bind_param("ii", $event_id, $user_id);

if ($stmt->execute()) {
    echo "<p>✅ Registration successful!</p>";
    echo "<a href='volunteer.php'>Back to Events</a>";
} else {
    echo "<p>❌ Error: " . $stmt->error . "</p>";
    echo "<a href='volunteer.php'>Back to Events</a>";
}

$stmt->close();
$conn->close();
?>
