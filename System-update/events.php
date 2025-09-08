<?php
session_start();

// Only volunteers can access
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Volunteer') {
    header("Location: index.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Database connection
include 'db_connect.php';

// Fetch all events, order by upcoming date
$sql = "SELECT e.*, u.username AS organization_name
        FROM events e
        JOIN users u ON e.organization_id = u.user_id
        WHERE e.event_date >= CURDATE()
        ORDER BY e.event_date ASC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Volunteer Events</title>
<link rel="stylesheet" href="styles.css">
<style>
.events-container { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px; margin-top:20px; }
.event-card { border:1px solid #ddd; border-radius:8px; padding:15px; background:#fff; box-shadow:0 3px 10px rgba(0,0,0,0.05);}
.btn { display:inline-block; padding:8px 15px; background:#4CAF50; color:#fff; text-decoration:none; border-radius:5px; margin-top:10px; }
</style>
</head>
<body>
<h1>Ongoing Volunteer Events</h1>
<div class="events-container">
<?php if ($result->num_rows > 0): ?>
    <?php while ($row = $result->fetch_assoc()): ?>
        <?php
        // Check if user already registered
        $stmt = $conn->prepare("SELECT * FROM event_registrations WHERE event_id=? AND volunteer_id=?");
        $stmt->bind_param("ii", $row['event_id'], $user_id);
        $stmt->execute();
        $regResult = $stmt->get_result();
        $alreadyRegistered = $regResult->num_rows > 0;
        $stmt->close();
        ?>
        <div class="event-card">
            <h3><?= htmlspecialchars($row['title']) ?></h3>
            <p><strong>Organization:</strong> <?= htmlspecialchars($row['organization_name']) ?></p>
            <p><?= htmlspecialchars($row['description']) ?></p>
            <p><strong>Location:</strong> <?= htmlspecialchars($row['location']) ?></p>
            <p><strong>Date:</strong> <?= date('d M Y', strtotime($row['event_date'])) ?></p>

            <?php if ($alreadyRegistered): ?>
                <button class="btn" disabled>Already Registered</button>
            <?php else: ?>
                <form method="POST" action="event_register.php">
                    <input type="hidden" name="event_id" value="<?= $row['event_id'] ?>">
                    <button type="submit" class="btn">Register</button>
                </form>
            <?php endif; ?>
            <?php if (isset($_GET['success'])): ?>
    <p style="color:green;">✅ You have successfully registered for the event!</p>
<?php endif; ?>

        </div>
    <?php endwhile; ?>
<?php else: ?>
    <p>No upcoming events available at the moment.</p>
<?php endif; ?>
</div>
<?php $conn->close(); ?>
</body>
</html>
