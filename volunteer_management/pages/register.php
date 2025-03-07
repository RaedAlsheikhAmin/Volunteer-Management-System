<?php
// Include the database connection file
include '../includes/db_connect.php';

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password for security
    $role = $_POST['role'];

    // Check if username already exists
    $check_sql = "SELECT * FROM users WHERE username = '$username'";
    $check_result = mysqli_query($conn, $check_sql);
    
    if (mysqli_num_rows($check_result) > 0) {
        echo "Username already exists!";
    } else {
        // Start a transaction to ensure data integrity
        mysqli_begin_transaction($conn);
        try {
            // Insert the new user into the 'users' table
            $sql_user = "INSERT INTO users (username, password, role) VALUES ('$username', '$password', '$role')";
            if (mysqli_query($conn, $sql_user)) {
                $user_id = mysqli_insert_id($conn); // Retrieve the last inserted user ID
                echo "User registered successfully!<br>";
                
                // If the role is 'volunteer', insert the volunteer's data into the 'volunteers' table
                if ($role == 'volunteer') {
                    $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
                    $last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
                    $email = mysqli_real_escape_string($conn, $_POST['email']);
                    $phone_number = mysqli_real_escape_string($conn, $_POST['phone_number']);
                    $date_of_birth = mysqli_real_escape_string($conn, $_POST['date_of_birth']);
                    $address = mysqli_real_escape_string($conn, $_POST['address']);

                    // Insert into volunteers table
                    $sql_volunteer = "INSERT INTO volunteers (user_id, first_name, last_name, email, phone_number, date_of_birth, address)
                                      VALUES ('$user_id', '$first_name', '$last_name', '$email', '$phone_number', '$date_of_birth', '$address')";
                    
                    if (mysqli_query($conn, $sql_volunteer)) {
                        echo "Volunteer registered successfully";
                    } else {
                        throw new Exception("Error inserting into volunteers table: " . mysqli_error($conn));
                    }
                }
                mysqli_commit($conn); // Commit the transaction only if everything is successful
            } else {
                throw new Exception("Error inserting into users table: " . mysqli_error($conn));
            }
        } catch (Exception $e) {
            echo $e->getMessage();
            mysqli_rollback($conn); // Roll back transaction in case of error
        }
    }
}

// Close the database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <h2>Register a New User</h2>
    <form action="register.php" method="POST">
        <label for="username">Username:</label>
        <input type="text" name="username" required><br>

        <label for="password">Password:</label>
        <input type="password" name="password" required><br>

        <label for="role">Role:</label>
        <select name="role" id="role" onchange="toggleVolunteerFields()">
            <option value="admin">Admin</option>
            <option value="volunteer">Volunteer</option>
        </select><br>

        <!-- Volunteer-specific fields (initially hidden for admin role) -->
        <div id="volunteer-fields" style="display: none;">
            <label for="first_name">First Name:</label>
            <input type="text" name="first_name"><br>

            <label for="last_name">Last Name:</label>
            <input type="text" name="last_name"><br>

            <label for="email">Email:</label>
            <input type="email" name="email"><br>

            <label for="phone_number">Phone Number:</label>
            <input type="text" name="phone_number"><br>

            <label for="date_of_birth">Date of Birth:</label>
            <input type="date" name="date_of_birth"><br>

            <label for="address">Address:</label>
            <textarea name="address"></textarea><br>
        </div>

        <input type="submit" value="Register">
    </form>

    <a href="login.php" class="register-link ">Already have an account? Login here</a>

    <script>
        function toggleVolunteerFields() {
            const role = document.getElementById('role').value;
            const volunteerFields = document.getElementById('volunteer-fields');
            if (role === 'volunteer') {
                volunteerFields.style.display = 'block';
            } else {
                volunteerFields.style.display = 'none';
            }
        }
    </script>
</body>
</html>
