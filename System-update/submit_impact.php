<?php
session_start();
include 'db_connect.php';

// Only volunteers can submit
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Volunteer') {
    header("Location: index.php");
    exit();
}
$sql = "SELECT e.event_id, e.title, e.event_date 
        FROM event_registrations er
        JOIN events e ON er.event_id = e.event_id
        WHERE er.volunteer_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $event_id = intval($_POST['event_id']);
    $volunteer_id = $_SESSION['user_id'];
    $contribution = trim($_POST['contribution']);
    $feedback = trim($_POST['feedback']);

    $stmt = $conn->prepare("INSERT INTO impact (event_id, volunteer_id, contribution, feedback) 
                            VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iiss", $event_id, $volunteer_id, $contribution, $feedback);

    if ($stmt->execute()) {
        echo "Your impact has been submitted!";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Submit Impact</title>
<style>
    body {
        font-family: Arial, sans-serif;
        background: #f4f6f9;
        margin: 0;
        padding: 0;
    }
    .form-container {
        max-width: 450px;
        margin: 60px auto;
        background: #fff;
        padding: 25px 30px;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    .form-container h2 {
        text-align: center;
        margin-bottom: 20px;
        color: #333;
    }
    label {
        font-weight: bold;
        display: block;
        margin: 12px 0 6px;
        color: #444;
    }
    input[type="number"],
    input[type="text"],
    textarea {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 6px;
        font-size: 14px;
        transition: border 0.3s;
    }
    input:focus, textarea:focus {
        border-color: #4CAF50;
        outline: none;
    }
    textarea {
        resize: vertical;
        min-height: 80px;
    }
    button {
        width: 100%;
        padding: 12px;
        margin-top: 15px;
        border: none;
        border-radius: 6px;
        background: #4CAF50;
        color: #fff;
        font-size: 16px;
        font-weight: bold;
        cursor: pointer;
        transition: background 0.3s;
    }
    button:hover {
        background: #45a049;
    }
</style>
</head>
<body>
   <div class="form-container">
        <h2>Submit Your Impact</h2>
        <form method="POST">
            <label for="event_id">Choose Event:</label>
            <select id="event_id" name="event_id" required>
                <option value="">-- Select Event --</option>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <option value="<?= $row['event_id'] ?>">
                        <?= htmlspecialchars($row['title']) ?>(<?= date("d M Y", strtotime($row['event_date'])) ?>)
                    </option>
                <?php endwhile; ?>
            </select>

            <label for="contribution">Contribution:</label>
            <input type="text" id="contribution" name="contribution" placeholder="e.g. 5 hours" required>

            <label for="feedback">Feedback:</label>
            <textarea id="feedback" name="feedback" placeholder="Share your experience..."></textarea>

            <button type="submit">Submit Impact</button>
        </form>
    </div>
</body>
</html>

