<?php
// Include the database connection file
include '../includes/db_connect.php';


// Get form data
$volunteer_id = $_POST['volunteer_id'];
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$email = $_POST['email'];
$phone_number = $_POST['phone_number'];
$date_of_birth = $_POST['date_of_birth'];
$address = $_POST['address'];

// Update the volunteer information in the database
$sql = "UPDATE volunteers 
        SET first_name = '$first_name', last_name = '$last_name', email = '$email', phone_number = '$phone_number',
            date_of_birth = '$date_of_birth', address = '$address'
        WHERE volunteer_id = $volunteer_id";

if (mysqli_query($conn, $sql)) {
    echo "Volunteer updated successfully!";
    echo '<br><a href="view_volunteers.php">Back to Volunteers List</a>';
} else {
    echo "Error updating volunteer: " . mysqli_error($conn);
}

// Close the database connection
mysqli_close($conn);
?>
