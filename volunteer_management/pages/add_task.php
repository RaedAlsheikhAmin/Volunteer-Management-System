<?php
// Include necessary files and check if the user is an admin
include '../includes/check_login.php';
include '../includes/db_connect.php';

// Check if the user is an admin
if ($_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

// Fetch events to associate tasks with
$sql_events = "SELECT event_id, event_name FROM events";
$result_events = mysqli_query($conn, $sql_events);
?>

<!DOCTYPE html>
<html lang="en">
<br><a href="admin_dashboard.php" class=button>Back to Admin Dashboard</a>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create New Task</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <h2>Create a New Task</h2>

    <form action="process_task.php" method="POST">
        <!-- Event Dropdown -->
        <label for="event_id">Select Event:</label>
        <select name="event_id" required>
            <option value="">-- Select an Event --</option>
            <?php
            // Populate event dropdown
            if (mysqli_num_rows($result_events) > 0) {
                while ($event = mysqli_fetch_assoc($result_events)) {
                    echo "<option value='" . $event['event_id'] . "'>" . $event['event_name'] . "</option>";
                }
            }
            ?>
        </select><br>

        <!-- Task Name -->
        <label for="task_name">Task Name:</label>
        <input type="text" name="task_name" required><br>

        <!-- Task Description -->
        <label for="task_description">Task Description:</label>
        <textarea name="task_description" required></textarea><br>

        <!-- Task Start Time -->
        <label for="start_time">Start Time:</label>
        <input type="datetime-local" name="start_time" required><br>

        <!-- Task End Time -->
        <label for="end_time">End Time:</label>
        <input type="datetime-local" name="end_time" required><br>

        <!-- Max Volunteers -->
        <label for="max_volunteers">Maximum Volunteers:</label>
        <input type="number" name="max_volunteers" min="1" required><br>

        <input type="submit" value="Create Task">
    </form>

    <a href="view_tasks.php" class="button">View All Tasks</a>
</body>
</html>

<?php
// Close the database connection
mysqli_close($conn);
?>
