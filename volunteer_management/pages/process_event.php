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
    // Get form data and sanitize it
    $event_name = mysqli_real_escape_string($conn, $_POST['event_name']);
    $event_date = mysqli_real_escape_string($conn, $_POST['event_date']);
    $event_location = mysqli_real_escape_string($conn, $_POST['event_location']);
    $event_description = mysqli_real_escape_string($conn, $_POST['event_description']);

    // Insert the event into the events table
    $sql = "INSERT INTO events (event_name, event_date, event_location, event_description) 
            VALUES ('$event_name', '$event_date', '$event_location', '$event_description')";

    if (mysqli_query($conn, $sql)) {
        echo "Event created successfully!";
        echo '<br><a href="view_events.php">View All Events</a>';
    } else {
        echo "Error: " . mysqli_error($conn);
    }

    // Close the connection
    mysqli_close($conn);
}
?>
