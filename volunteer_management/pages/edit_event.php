<?php
// Include necessary files
include '../includes/db_connect.php';
include '../includes/check_login.php';

// Check if the user is an admin
if ($_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

// Get the event ID from the URL
$event_id = mysqli_real_escape_string($conn, $_GET['id']);

// Fetch the event details from the database
$sql = "SELECT * FROM events WHERE event_id = $event_id";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    $event = mysqli_fetch_assoc($result);
} else {
    echo "Event not found.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Event</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <h2>Edit Event</h2>

    <form action="process_edit_event.php" method="POST">
        <input type="hidden" name="event_id" value="<?php echo $event['event_id']; ?>">

        <!-- Event Name -->
        <label for="event_name">Event Name:</label>
        <input type="text" name="event_name" value="<?php echo htmlspecialchars($event['event_name']); ?>" required><br>

        <!-- Event Date -->
        <label for="event_date">Event Date:</label>
        <input type="date" name="event_date" value="<?php echo htmlspecialchars($event['event_date']); ?>" required><br>

        <!-- Event Location -->
        <label for="event_location">Event Location:</label>
        <input type="text" name="event_location" value="<?php echo htmlspecialchars($event['event_location']); ?>" required><br>

        <!-- Event Description -->
        <label for="event_description">Event Description:</label>
        <textarea name="event_description" required><?php echo htmlspecialchars($event['event_description']); ?></textarea><br>

        <input type="submit" value="Update Event">
    </form>

    <a href="view_events.php" class="button">Back to Events</a>
</body>
</html>

<?php
// Close the database connection
mysqli_close($conn);
?>
