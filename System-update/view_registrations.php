<?php
session_start();
include 'db_connect.php';

// Only allow organizations
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'Organization') {
    header("Location: index.php");
    exit();
}

$org_id = $_SESSION['user_id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>My Events & Registrations</title>
<link rel="stylesheet" href="styles.css">
<style>
body { font-family: Arial, sans-serif; background:#f5f5f5; margin:0; padding:0; }
.container { max-width:1000px; margin:20px auto; padding:0 20px; }
header { background:white; padding:15px 0; box-shadow:0 2px 6px rgba(0,0,0,0.1); margin-bottom:20px; text-align:center; }
h1 { margin:0; color:#333; }
.event-card { background:white; border-radius:8px; padding:15px; margin-bottom:20px; box-shadow:0 3px 10px rgba(0,0,0,0.05); }
.event-card h2 { margin:0 0 10px 0; color:#4a90e2; }
.reg-card { background:#f9f9f9; border-radius:6px; padding:10px; margin:5px 0; }
.reg-card p { margin:3px 0; }
.btn { display:inline-block; padding:8px 15px; background:#4CAF50; color:#fff; text-decoration:none; border-radius:5px; margin-top:10px; }
</style>
</head>
<body>

<header>
    <h1>My Events & Registrations</h1>
</header>

<div class="container">
<?php
// Get all events created by this organization
$stmt = $conn->prepare("SELECT event_id, title, description, location, event_date FROM events WHERE organization_id = ?");
$stmt->bind_param("i", $org_id);
$stmt->execute();
$events = $stmt->get_result();

if ($events->num_rows > 0):
    while($event = $events->fetch_assoc()):
        ?>
        <div class="event-card">
            <h2><?php echo htmlspecialchars($event['title']); ?> (<?php echo htmlspecialchars($event['event_date']); ?>)</h2>
            <p><strong>Description:</strong> <?php echo htmlspecialchars($event['description']); ?></p>
            <p><strong>Location:</strong> <?php echo htmlspecialchars($event['location']); ?></p>

            <h3>Registrations:</h3>
            <?php
            // Get volunteers for this event
            $stmt2 = $conn->prepare("
                SELECT u.username, u.email, u.phone, u.nic
                FROM event_registrations er
                JOIN users u ON er.volunteer_id = u.user_id
                WHERE er.event_id = ?
            ");
            $stmt2->bind_param("i", $event['event_id']);
            $stmt2->execute();
            $regs = $stmt2->get_result();

            if ($regs->num_rows > 0):
                while($reg = $regs->fetch_assoc()):
                    ?>
                    <div class="reg-card">
                        <p><strong>Name:</strong> <?php echo htmlspecialchars($reg['username']); ?></p>
                        <p><strong>Email:</strong> <?php echo htmlspecialchars($reg['email']); ?></p>
                        <p><strong>Phone:</strong> <?php echo htmlspecialchars($reg['phone']); ?></p>
                        <p><strong>NIC:</strong> <?php echo htmlspecialchars($reg['nic']); ?></p>
                    </div>
                <?php
                endwhile;
            else:
                echo "<p>No volunteers have registered yet.</p>";
            endif;
            $stmt2->close();
            ?>
        </div>
    <?php
    endwhile;
else:
    echo "<p>You have not created any events yet.</p>";
endif;

$stmt->close();
$conn->close();
?>
<a href="organization_dashboard.php" class="btn">Back to Dashboard</a>
</div>

</body>
</html>
