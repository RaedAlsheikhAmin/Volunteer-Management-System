<?php
// Include necessary files and check if the user is an admin
include '../includes/check_login.php';
include '../includes/db_connect.php';

// Check if the user is an admin
if ($_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<a href="admin_dashboard.php" class="button">Back to Admin Dashboard</a>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create New Event</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <h2>Create a New Event</h2>

    <form action="process_event.php" method="POST">
        <!-- Event Name -->
        <label for="event_name">Event Name:</label>
        <input type="text" name="event_name" required><br>

        <!-- Event Date -->
        <label for="event_date">Event Date:</label>
        <input type="date" name="event_date" required><br>

        <!-- Event Location -->
        <label for="event_location">Event Location:</label>
        <input type="text" name="event_location" required><br>

        <!-- Event Description -->
        <label for="event_description">Event Description:</label>
        <textarea name="event_description" required></textarea><br>

        <input type="submit" value="Create Event">
    </form>

    <a href="view_events.php" class="button">View All Events</a>
</body>
</html>

<?php
// Close the database connection
mysqli_close($conn);
?>
