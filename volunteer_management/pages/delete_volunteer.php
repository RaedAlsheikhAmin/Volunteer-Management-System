<?php
// Include the database connection file
include '../includes/db_connect.php';

// Get the volunteer ID from the URL and sanitize it
$volunteer_id = mysqli_real_escape_string($conn, $_GET['id']);

// Find the user ID associated with the volunteer
$sql_user = "SELECT user_id FROM volunteers WHERE volunteer_id = $volunteer_id";
$result_user = mysqli_query($conn, $sql_user);

if (mysqli_num_rows($result_user) > 0) {
    $row = mysqli_fetch_assoc($result_user);
    $user_id = $row['user_id']; // Get the user ID

    // Ensure the user ID is valid
    if ($user_id) {
        // Delete the user from the users table, which will automatically delete the associated volunteer (due to ON DELETE CASCADE)
        $sql_delete_user = "DELETE FROM users WHERE user_id = $user_id";
        
        if (mysqli_query($conn, $sql_delete_user)) {
            echo "Volunteer and associated user deleted successfully!";
            echo '<br><a href="view_volunteers.php">Back to Volunteers List</a>';
        } else {
            echo "Error deleting user: " . mysqli_error($conn);
        }
    } else {
        echo "No valid user ID found for this volunteer.";
    }
} else {
    echo "Volunteer not found.";
}

// Close the database connection
mysqli_close($conn);
?>
