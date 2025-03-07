<?php
// Include the database connection file
include '../includes/db_connect.php';
session_start();



// Fetch the volunteer ID from the URL, if it exists
$selected_volunteer_id = isset($_GET['volunteer_id']) ? $_GET['volunteer_id'] : '';

// Fetch all volunteers
$volunteer_sql = "SELECT volunteer_id, CONCAT(first_name, ' ', last_name) AS full_name FROM volunteers";
$volunteer_result = mysqli_query($conn, $volunteer_sql);

// Fetch all tasks
$task_sql = "SELECT task_id, task_name FROM tasks";
$task_result = mysqli_query($conn, $task_sql);
?>

<!DOCTYPE html>
<html lang="en">
<a href="logout.php" class="button logout-button">Logout</a>
<br><a href="admin_dashboard.php" class=button>Back to Admin Dashboard</a>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assign Task to Volunteer</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <h2>Assign Task to Volunteer</h2>

    <form action="process_assignment.php" method="POST">
        <label for="volunteer_id">Select Volunteer:</label>
        <select name="volunteer_id" required>
            <option value="">-- Select Volunteer --</option>
            <?php
            if (mysqli_num_rows($volunteer_result) > 0) {
                while ($volunteer = mysqli_fetch_assoc($volunteer_result)) {
                    // Pre-select the volunteer if 'volunteer_id' is passed in the URL
                    $selected = ($volunteer['volunteer_id'] == $selected_volunteer_id) ? 'selected' : '';
                    echo "<option value='" . $volunteer['volunteer_id'] . "' $selected>" . $volunteer['full_name'] . "</option>";
                }
            } else {
                echo "<option value=''>No volunteers available</option>";
            }
            ?>
        </select><br>

        <label for="task_id">Select Task:</label>
        <select name="task_id" required>
            <option value="">-- Select Task --</option>
            <?php
            if (mysqli_num_rows($task_result) > 0) {
                while ($task = mysqli_fetch_assoc($task_result)) {
                    echo "<option value='" . $task['task_id'] . "'>" . $task['task_name'] . "</option>";
                }
            } else {
                echo "<option value=''>No tasks available</option>";
            }
            ?>
        </select><br>

        <input type="submit" value="Assign Task">
    </form>

    <a href="view_volunteers.php"class="button">View All Volunteers</a>
    <a href="view_assignments.php"class="button">View All Assignments</a>

</body>
</html>
