<?php
// Include necessary files
include '../includes/db_connect.php';
include '../includes/check_login.php';

// Check if the user is an admin
if ($_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

// Get the event ID from the URL and sanitize it
$event_id = mysqli_real_escape_string($conn, $_GET['id']);

// Delete the event from the database
$sql = "DELETE FROM events WHERE event_id = $event_id";

if (mysqli_query($conn, $sql)) {
    echo "Event deleted successfully!";
    echo '<br><a href="view_events.php">Back to Events</a>';
} else {
    echo "Error deleting event: " . mysqli_error($conn);
}

// Close the database connection
mysqli_close($conn);
?>
