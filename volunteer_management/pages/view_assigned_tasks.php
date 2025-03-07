<?php
// Include the necessary files for session check and database connection
include '../includes/check_login.php';
include '../includes/db_connect.php';

// Check if the logged-in user is a volunteer
if ($_SESSION['role'] != 'volunteer') {
    header("Location: login.php");
    exit();
}

// Get the logged-in volunteer's ID from the session (assuming volunteer ID is stored in session)
$volunteer_id = $_SESSION['user_id'];

// Fetch tasks assigned to the logged-in volunteer
$sql = "SELECT t.task_name, t.task_description, a.status 
        FROM assignments a
        JOIN tasks t ON a.task_id = t.task_id
        WHERE a.volunteer_id = $volunteer_id";

$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<br><a href="admin_dashboard.php" class=button>Back to Admin Dashboard</a>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assigned Tasks</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <h2>Your Assigned Tasks</h2>

    <table border="1">
        <tr>
            <th>Task Name</th>
            <th>Description</th>
            <th>Status</th>
        </tr>
        <?php
        // Display assigned tasks in the table
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['task_name']) . "</td>";
                echo "<td>" . htmlspecialchars($row['task_description']) . "</td>";
                echo "<td>" . ucfirst(htmlspecialchars($row['status'])) . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='3'>No tasks assigned yet.</td></tr>";
        }
        ?>
    </table>

    <a href="volunteer_dashboard.php" class="button">Back to Dashboard</a>
</body>
</html>

<?php
// Close the database connection
mysqli_close($conn);
?>
