<?php
include '../includes/check_login.php';



// Check if the user is logged in and is a volunteer
// Check if the user is a volunteer
if ($_SESSION['role'] != 'volunteer') {
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
    <title>Volunteer Dashboard</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <h2>Welcome, Volunteer!</h2>
    <p>Here, you can view your assigned tasks.</p>

    <ul class="nav-menu">
    <li><a href="view_assigned_tasks.php">View Assigned Tasks</a></li>
    <li><a href="change_password.php">Change Password</a></li> 
   
    </ul>

    
</body>
</html>
