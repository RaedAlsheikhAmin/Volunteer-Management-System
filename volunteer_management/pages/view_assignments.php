<?php
// Include the database connection file
include '../includes/db_connect.php';
session_start();

// Fetch all volunteers for filter
$volunteer_sql = "SELECT volunteer_id, CONCAT(first_name, ' ', last_name) AS full_name FROM volunteers";
$volunteer_result = mysqli_query($conn, $volunteer_sql);

// Fetch the filter values from the form (if submitted)
$selected_volunteer = isset($_GET['volunteer_id']) ? $_GET['volunteer_id'] : '';
$selected_status = isset($_GET['status']) ? $_GET['status'] : '';

// Build the query with optional filters
$sql = "SELECT a.assignment_id, v.first_name, v.last_name, t.task_name, a.status
        FROM assignments a
        JOIN volunteers v ON a.volunteer_id = v.volunteer_id
        JOIN tasks t ON a.task_id = t.task_id
        WHERE 1=1";

if ($selected_volunteer) {
    $sql .= " AND a.volunteer_id = $selected_volunteer";
}
if ($selected_status) {
    $sql .= " AND a.status = '$selected_status'";
}

$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<a href="logout.php" class="button logout-button">Logout</a>
<br><a href="admin_dashboard.php" class=button>Back to Admin Dashboard</a>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Assignments</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

    <div class="container">
        <h2>All Task Assignments</h2>

        <!-- Filter form -->
        <form method="GET" action="view_assignments.php">
            <label for="volunteer_id">Filter by Volunteer:</label>
            <select name="volunteer_id">
                <option value="">-- All Volunteers --</option>
                <?php
                if (mysqli_num_rows($volunteer_result) > 0) {
                    while ($volunteer = mysqli_fetch_assoc($volunteer_result)) {
                        $selected = ($volunteer['volunteer_id'] == $selected_volunteer) ? 'selected' : '';
                        echo "<option value='" . $volunteer['volunteer_id'] . "' $selected>" . $volunteer['full_name'] . "</option>";
                    }
                }
                ?>
            </select>

            <label for="status">Filter by Status:</label>
            <select name="status">
                <option value="">-- All Statuses --</option>
                <option value="assigned" <?php if ($selected_status == 'assigned') echo 'selected'; ?>>Assigned</option>
                <option value="in_progress" <?php if ($selected_status == 'in_progress') echo 'selected'; ?>>In Progress</option>
                <option value="completed" <?php if ($selected_status == 'completed') echo 'selected'; ?>>Completed</option>
            </select>

            <input type="submit" value="Filter" class="button">
        </form>

        <table>
            <tr>
                <th>ID</th>
                <th>Volunteer Name</th>
                <th>Task</th>
                <th>Status</th>
                <th>Change Status</th>
            </tr>
            <?php
            // Display assignments in table
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $row['assignment_id'] . "</td>";
                    echo "<td>" . $row['first_name'] . " " . $row['last_name'] . "</td>";
                    echo "<td>" . $row['task_name'] . "</td>";
                    echo "<td>" . ucfirst($row['status']) . "</td>";
                    echo "<td>
                        <form action='update_assignment_status.php' method='POST'>
                            <input type='hidden' name='assignment_id' value='" . $row['assignment_id'] . "'>
                            <select name='status'>
                                <option value='assigned'" . ($row['status'] == 'assigned' ? ' selected' : '') . ">Assigned</option>
                                <option value='in_progress'" . ($row['status'] == 'in_progress' ? ' selected' : '') . ">In Progress</option>
                                <option value='completed'" . ($row['status'] == 'completed' ? ' selected' : '') . ">Completed</option>
                            </select>
                            <input type='submit' value='Update' class='button'>
                        </form>
                    </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No assignments found</td></tr>";
            }
            ?>
        </table>

        <a href="assign_task.php" class="button">Assign New Task</a>
        <a href="view_volunteers.php" class="button">View All Volunteers</a>
        <a href="volunteer_report.php"class="button">View Volunteer Report</a>
    </div>

</body>
</html>

<?php
// Close the database connection
mysqli_close($conn);
?>
