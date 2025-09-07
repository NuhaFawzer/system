<?php
require_once 'db.php';
require_once 'auth.php';
require_login();

$uid = current_user()['id'];
$action = $_GET['action'] ?? '';
$event_id = intval($_GET['event_id'] ?? 0);

if ($event_id > 0) {
    if ($action === 'join') {
        // check capacity
        $cap = $conn->query("SELECT slots, (SELECT COUNT(*) FROM assignments WHERE event_id={$event_id}) AS cnt FROM events WHERE id={$event_id}");
        if ($cap && $cap->num_rows) {
            $row = $cap->fetch_assoc();
            if ((int)$row['cnt'] < (int)$row['slots']) {
                $conn->query("INSERT IGNORE INTO assignments (event_id, user_id) VALUES ({$event_id}, {$uid})");
            }
        }
    } elseif ($action === 'cancel') {
        $conn->query("DELETE FROM assignments WHERE event_id={$event_id} AND user_id={$uid}");
    }
}

header('Location: events.php');
exit;
?>
