<?php
// db.php - Database connection (mysqli)
$DB_HOST = 'localhost';
$DB_USER = 'root';
$DB_PASS = '';          // change if needed
$DB_NAME = 'volunteer_db'; // must match init.sql

$conn = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
if ($conn->connect_error) {
    die('Database connection failed: ' . $conn->connect_error);
}
?>
