<?php
// Include necessary files
include '../includes/db_connect.php';
include '../includes/check_login.php';

// Check if the user is an admin
if ($_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the form data and sanitize it
    $event_id = mysqli_real_escape_string($conn, $_POST['event_id']);
    $event_name = mysqli_real_escape_string($conn, $_POST['event_name']);
    $event_date = mysqli_real_escape_string($conn, $_POST['event_date']);
    $event_location = mysqli_real_escape_string($conn, $_POST['event_location']);
    $event_description = mysqli_real_escape_string($conn, $_POST['event_description']);

    // Update the event in the database
    $sql = "UPDATE events 
            SET event_name = '$event_name', event_date = '$event_date', 
                event_location = '$event_location', event_description = '$event_description' 
            WHERE event_id = $event_id";

    if (mysqli_query($conn, $sql)) {
        echo "Event updated successfully!";
        echo '<br><a href="view_events.php">Back to Events</a>';
    } else {
        echo "Error updating event: " . mysqli_error($conn);
    }

    // Close the database connection
    mysqli_close($conn);
}
?>
