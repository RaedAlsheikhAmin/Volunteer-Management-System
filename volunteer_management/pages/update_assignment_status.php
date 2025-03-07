<?php
// Include the database connection file
include '../includes/db_connect.php';


// Get form data
$assignment_id = $_POST['assignment_id'];
$status = $_POST['status'];

// Update the task status in the 'assignments' table
$sql = "UPDATE assignments SET status = '$status' WHERE assignment_id = $assignment_id";

if (mysqli_query($conn, $sql)) {
    echo "Status updated successfully!";
} else {
    echo "Error updating status: " . mysqli_error($conn);
}

echo '<br><a href="view_assignments.php">Back to Assignments List</a>';

// Close the database connection
mysqli_close($conn);
?>
