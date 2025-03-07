<?php
// Include necessary files
include '../includes/db_connect.php';
include '../includes/check_login.php';

// Check if the user is an admin
if ($_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

// Fetch all events from the database
$sql = "SELECT * FROM events";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<a href="admin_dashboard.php" class="button">Back to Admin Dashboard</a>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Events</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <h2>All Events</h2>
    <table border="1">
        <tr>
            <th>Event Name</th>
            <th>Date</th>
            <th>Location</th>
            <th>Description</th>
            <th>Actions</th>
        </tr>
        <?php
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['event_name']) . "</td>";
                echo "<td>" . htmlspecialchars($row['event_date']) . "</td>";
                echo "<td>" . htmlspecialchars($row['event_location']) . "</td>";
                echo "<td>" . htmlspecialchars($row['event_description']) . "</td>";
                echo "<td><a href='edit_event.php?id=" . $row['event_id'] . "'>Edit</a> | 
                         <a href='delete_event.php?id=" . $row['event_id'] . "'>Delete</a></td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='5'>No events found.</td></tr>";
        }
        ?>
    </table>

    <a href="add_event.php" class="button">Create New Event</a>
    <a href="add_task.php" class="button">Create New Task</a>
</body>
</html>

<?php
// Close the database connection
mysqli_close($conn);
?>
