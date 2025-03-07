<?php
// Include necessary files
include '../includes/db_connect.php';
include '../includes/check_login.php';

// Check if the user is an admin
if ($_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

// Fetch all tasks along with their associated events
$sql = "SELECT t.task_id, t.task_name, t.task_description, t.start_time, t.end_time, t.max_volunteers, e.event_name 
        FROM tasks t
        JOIN events e ON t.event_id = e.event_id";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<br><a href="admin_dashboard.php" class=button>Back to Admin Dashboard</a>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Tasks</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <h2>All Tasks</h2>
    <table border="1">
        <tr>
            <th>Task Name</th>
            <th>Event</th>
            <th>Description</th>
            <th>Start Time</th>
            <th>End Time</th>
            <th>Max Volunteers</th>
            <th>Actions</th>
        </tr>
        <?php
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['task_name']) . "</td>";
                echo "<td>" . htmlspecialchars($row['event_name']) . "</td>";
                echo "<td>" . htmlspecialchars($row['task_description']) . "</td>";
                echo "<td>" . htmlspecialchars($row['start_time']) . "</td>";
                echo "<td>" . htmlspecialchars($row['end_time']) . "</td>";
                echo "<td>" . htmlspecialchars($row['max_volunteers']) . "</td>";
                echo "<td><a href='edit_task.php?id=" . $row['task_id'] . "'>Edit</a> | 
                         <a href='delete_task.php?id=" . $row['task_id'] . "'>Delete</a></td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='7'>No tasks found.</td></tr>";
        }
        ?>
    </table>

    <a href="add_task.php" class="button">Create New Task</a>
    <a href="assign_task.php" class="button">Assign Volunteer</a>
</body>
</html>

<?php
// Close the database connection
mysqli_close($conn);
?>
