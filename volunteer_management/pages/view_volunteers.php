<?php
// Include the database connection file
include '../includes/db_connect.php';
include '../includes/check_login.php';


// Check if the user is an admin
if ($_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}
// Fetch all volunteers

$sql = "SELECT * FROM volunteers";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<a href="logout.php" class="button logout-button">Logout</a>
<br><a href="admin_dashboard.php" class=button>Back to Admin Dashboard</a>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Volunteers</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <h2>List of Volunteers</h2>

    <table border="1">
        <tr>
            <th>ID</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email</th>
            <th>Phone Number</th>
            <th>Date of Birth</th>
            <th>Address</th>
            <th>Actions</th>
        </tr>
        <?php
        // Display volunteers data in table
        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row['volunteer_id'] . "</td>";
                echo "<td>" . $row['first_name'] . "</td>";
                echo "<td>" . $row['last_name'] . "</td>";
                echo "<td>" . $row['email'] . "</td>";
                echo "<td>" . $row['phone_number'] . "</td>";
                echo "<td>" . $row['date_of_birth'] . "</td>";
                echo "<td>" . $row['address'] . "</td>";
                echo "<td>
                        <a href='edit_volunteer.php?id=" . $row['volunteer_id'] . "' class='action-link'>Edit</a> | 
                        <a href='delete_volunteer.php?id=" . $row['volunteer_id'] . "' class='action-link' onclick=\"return confirm('Are you sure you want to delete this volunteer?');\">Delete</a> |
                        <a href='assign_task.php?volunteer_id=" . $row['volunteer_id'] . "' class='action-link'>Assign Task</a>

                      </td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='8'>No volunteers found</td></tr>";
        }
        ?>
    </table>

    <a href="add_volunteer.php" class="button">Add New Volunteer</a>
    <a href="view_assignments.php" class="button">View All Assignments</a>
    <a href="volunteer_report.php"class="button">View Volunteer Report</a>

</body>
</html>

<?php
// Close the database connection
mysqli_close($conn);
?>
