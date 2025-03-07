<?php
// Include the database connection file
include '../includes/db_connect.php';



// Get form data
$volunteer_id = $_POST['volunteer_id'];
$task_id = $_POST['task_id'];

// Fetch volunteer and task information for future use if needed
$volunteer_sql = "SELECT CONCAT(first_name, ' ', last_name) AS full_name FROM volunteers WHERE volunteer_id = $volunteer_id";
$volunteer_result = mysqli_query($conn, $volunteer_sql);
$volunteer = mysqli_fetch_assoc($volunteer_result);

$task_sql = "SELECT task_name FROM tasks WHERE task_id = $task_id";
$task_result = mysqli_query($conn, $task_sql);
$task = mysqli_fetch_assoc($task_result);

// Check if the assignment already exists
$check_sql = "SELECT * FROM assignments WHERE volunteer_id = $volunteer_id AND task_id = $task_id";
$check_result = mysqli_query($conn, $check_sql);

if (mysqli_num_rows($check_result) > 0) {
    echo "This volunteer is already assigned to this task.";
} else {
    // Insert assignment into the 'assignments' table
    $sql = "INSERT INTO assignments (volunteer_id, task_id, status) VALUES ($volunteer_id, $task_id, 'assigned')";

    if (mysqli_query($conn, $sql)) {
        echo "Task assigned successfully!";
    } else {
        echo "Error assigning task: " . mysqli_error($conn);
    }
}

echo '<br><a href="assign_task.php">Assign Another Task</a>';
echo '<br><a href="view_assignments.php">View All Assignments</a>';

// Close the database connection
mysqli_close($conn);
?>
