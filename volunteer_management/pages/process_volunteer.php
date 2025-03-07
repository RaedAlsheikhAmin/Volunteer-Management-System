<?php
// Include the database connection file
include '../includes/db_connect.php';

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve and sanitize form data
    $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
    $last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone_number = mysqli_real_escape_string($conn, $_POST['phone_number']);
    $date_of_birth = mysqli_real_escape_string($conn, $_POST['date_of_birth']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    
    // Generate a default username and password (optional)
    $username = strtolower($first_name) . '.' . strtolower($last_name); // Default username: first.last
    $default_password = password_hash('00000000', PASSWORD_DEFAULT); // Default password

    // Start a transaction to ensure data integrity
    mysqli_begin_transaction($conn);
    try {
        // Insert into the users table first
        $sql_user = "INSERT INTO users (username, password, role) VALUES ('$username', '$default_password', 'volunteer')";
        if (mysqli_query($conn, $sql_user)) {
            // Retrieve the newly inserted user ID
            $user_id = mysqli_insert_id($conn);

            // Insert the volunteer's data into the volunteers table with the retrieved user_id
            $sql_volunteer = "INSERT INTO volunteers (user_id, first_name, last_name, email, phone_number, date_of_birth, address)
                              VALUES ('$user_id', '$first_name', '$last_name', '$email', '$phone_number', '$date_of_birth', '$address')";

            if (mysqli_query($conn, $sql_volunteer)) {
                mysqli_commit($conn); // Commit the transaction if both inserts succeed
                echo "Volunteer added successfully!";
                echo '<br><a href="view_volunteers.php">View All Volunteers</a>';
            } else {
                throw new Exception("Error inserting into volunteers table: " . mysqli_error($conn));
            }
        } else {
            throw new Exception("Error inserting into users table: " . mysqli_error($conn));
        }
    } catch (Exception $e) {
        echo $e->getMessage();
        mysqli_rollback($conn); // Roll back the transaction if an error occurs
    }
}

// Close the database connection
mysqli_close($conn);
?>
