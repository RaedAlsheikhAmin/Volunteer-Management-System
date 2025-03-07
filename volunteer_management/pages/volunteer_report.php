<?php
// Include the database connection file
include '../includes/db_connect.php';
include '../includes/check_login.php'; // Ensure the user is logged in

// Check if the user is either admin or volunteer
if ($_SESSION['role'] != 'admin') {
    header("Location: login.php"); // Redirect if they don't have permission
    exit();
}

// Fetch volunteer participation stats
$sql = "SELECT v.first_name, v.last_name, 
        SUM(CASE WHEN a.status = 'completed' THEN 1 ELSE 0 END) AS completed_tasks, 
        SUM(CASE WHEN a.status = 'in_progress' THEN 1 ELSE 0 END) AS in_progress_tasks
        FROM volunteers v
        LEFT JOIN assignments a ON v.volunteer_id = a.volunteer_id
        GROUP BY v.volunteer_id";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<a href="logout.php" class="button logout-button">Logout</a>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Volunteer Task Report</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <h2>Volunteer Task Report</h2>

    <table border="1">
        <tr>
            <th>Volunteer Name</th>
            <th>Completed Tasks</th>
            <th>In Progress Tasks</th>
        </tr>
        <?php
        // Display report data
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row['first_name'] . " " . $row['last_name'] . "</td>";
                echo "<td>" . $row['completed_tasks'] . "</td>";
                echo "<td>" . $row['in_progress_tasks'] . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='3'>No data available</td></tr>";
        }
        ?>
    </table>

    <br><a href="admin_dashboard.php" class=button>Back to Admin Dashboard</a>
</body>
</html>

<?php
// Close the database connection
mysqli_close($conn);
?>
