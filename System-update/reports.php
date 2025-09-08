<?php
session_start();
include 'db_connect.php';

// Only admin can access reports
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Admin') {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Reports</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        h1, h2 { color: #333; }
        .summary { display: flex; gap: 20px; margin-bottom: 20px; }
        .card { padding: 15px; background-color: #f2f2f2; border-radius: 8px; flex: 1; text-align: center; font-weight: bold; }
        table { border-collapse: collapse; width: 100%; margin-bottom: 30px; }
        th, td { border: 1px solid #333; padding: 8px; text-align: left; }
        th { background-color: #e2e2e2; }
        tr:nth-child(even) { background-color: #f9f9f9; }
    </style>
</head>
<body>
    <h1>Admin Reports</h1>

<?php
// Total Volunteers
$sql = "SELECT COUNT(*) AS total_volunteers FROM users WHERE role='Volunteer'";
$result = mysqli_query($conn, $sql);
$volunteers = mysqli_fetch_assoc($result);

// Total Events
$sql = "SELECT COUNT(*) AS total_events FROM events";
$result = mysqli_query($conn, $sql);
$events = mysqli_fetch_assoc($result);

// Summary Cards
echo "<div class='summary'>
        <div class='card'>Total Volunteers: {$volunteers['total_volunteers']}</div>
        <div class='card'>Total Events: {$events['total_events']}</div>
      </div>";
?>

<h2>All Events</h2>
<table>
    <tr>
        <th>Event ID</th>
        <th>Title</th>
        <th>Date</th>
        <th>Organizer</th>
    </tr>
<?php
$sql = "SELECT e.event_id, e.title, e.event_date, u.username AS organizer
        FROM events e
        JOIN users u ON e.organization_id = u.user_id";
$result = mysqli_query($conn, $sql);
while ($event = mysqli_fetch_assoc($result)) {
    echo "<tr>
            <td>".htmlspecialchars($event['event_id'])."</td>
            <td>".htmlspecialchars($event['title'])."</td>
            <td>".htmlspecialchars($event['event_date'])."</td>
            <td>".htmlspecialchars($event['organizer'])."</td>
          </tr>";
}
?>
</table>

<h2>Volunteer Registrations</h2>
<table>
    <tr>
        <th>Event</th>
        <th>Volunteer Name</th>
        <th>Email</th>
        <th>Phone</th>
    </tr>
<?php
$sql = "SELECT e.title, u.username AS volunteer_name, u.email, u.phone
        FROM event_registrations er
        JOIN events e ON er.event_id = e.event_id
        JOIN users u ON er.volunteer_id = u.user_id";
$result = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr>
            <td>".htmlspecialchars($row['title'])."</td>
            <td>".htmlspecialchars($row['volunteer_name'])."</td>
            <td>".htmlspecialchars($row['email'])."</td>
            <td>".htmlspecialchars($row['phone'])."</td>
          </tr>";
}
?>
</table>

<h2>Impact of Volunteers</h2>
<table>
    <tr>
        <th>Event</th>
        <th>Volunteer</th>
        <th>Contribution</th>
        <th>Feedback</th>
        <th>Date</th>
    </tr>
<?php
$sql = "SELECT e.title, u.username AS volunteer_name, i.contribution, i.feedback, i.date_recorded
        FROM impact i
        JOIN events e ON i.event_id = e.event_id
        JOIN users u ON i.volunteer_id = u.user_id";
$result = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr>
            <td>".htmlspecialchars($row['title'])."</td>
            <td>".htmlspecialchars($row['volunteer_name'])."</td>
            <td>".htmlspecialchars($row['contribution'])."</td>
            <td>".htmlspecialchars($row['feedback'])."</td>
            <td>".htmlspecialchars($row['date_recorded'])."</td>
          </tr>";
}
?>
</table>
</body>
</html>
