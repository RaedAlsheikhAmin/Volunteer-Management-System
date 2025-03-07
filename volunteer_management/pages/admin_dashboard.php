<?php

include '../includes/db_connect.php';
include '../includes/check_login.php';
// Check if the user is logged in and is an admin
// Check if the user is an admin
if ($_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<a href="logout.php" class="button logout-button">Logout</a>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <h2>Welcome, Admin!</h2>
    
    <ul class="nav-menu">
    <li><a href="view_volunteers.php">Manage Volunteers</a></li>
    <li><a href="assign_task.php">Assign Tasks</a></li>
    <li><a href="view_assignments.php">View Assignments</a></li>
    <li><a href="volunteer_report.php">View Volunteer Report</a></li> 
    <li><a href="add_task.php" >Create New Task</a></li>
    <li><a href="view_tasks.php" >View Tasks</a></li>
    <li><a href="add_event.php">Create New Event</a></li>
    <li><a href="view_events.php">View Events</a></li>
    </ul>



</body>
</html>
