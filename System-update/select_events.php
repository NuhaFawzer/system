<?php
include 'db_connect.php';

$result = $conn->query("SELECT event_id, title, location, event_date FROM events");

if($result->num_rows > 0){
    while($row = $result->fetch_assoc()){
        echo "Event ID: ".$row['event_id']." | ".$row['title']." at ".$row['location']." on ".$row['event_date']."<br>";
    }
} else {
    echo "No events found.";
}

$conn->close();
?>
