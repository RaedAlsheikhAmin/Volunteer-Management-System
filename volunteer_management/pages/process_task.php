<?php
// Include necessary files
include '../includes/db_connect.php';
include '../includes/check_login.php';

// Check if the user is an admin
if ($_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data and sanitize it
    $event_id = mysqli_real_escape_string($conn, $_POST['event_id']);
    $task_name = mysqli_real_escape_string($conn, $_POST['task_name']);
    $task_description = mysqli_real_escape_string($conn, $_POST['task_description']);
    $start_time = mysqli_real_escape_string($conn, $_POST['start_time']);
    $end_time = mysqli_real_escape_string($conn, $_POST['end_time']);
    $max_volunteers = mysqli_real_escape_string($conn, $_POST['max_volunteers']);

    // Insert the task into the tasks table
    $sql = "INSERT INTO tasks (event_id, task_name, task_description, start_time, end_time, max_volunteers) 
            VALUES ('$event_id', '$task_name', '$task_description', '$start_time', '$end_time', '$max_volunteers')";

    if (mysqli_query($conn, $sql)) {
        echo "Task created successfully!";
        echo '<br><a href="view_tasks.php">View All Tasks</a>';
    } else {
        echo "Error: " . mysqli_error($conn);
    }

    // Close the connection
    mysqli_close($conn);
}
?>
