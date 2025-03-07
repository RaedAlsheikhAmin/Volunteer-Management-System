<?php
// Include necessary files and start session
include '../includes/check_login.php';
include '../includes/db_connect.php';

// Check if the user is a volunteer
if ($_SESSION['role'] != 'volunteer') {
    header("Location: login.php");
    exit();
}

// Process form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $current_password = mysqli_real_escape_string($conn, $_POST['current_password']);
    $new_password = mysqli_real_escape_string($conn, $_POST['new_password']);
    $confirm_password = mysqli_real_escape_string($conn, $_POST['confirm_password']);

    // Check if the new passwords match
    if ($new_password != $confirm_password) {
        echo "The new passwords do not match!";
    } else {
        // Get the user's current password from the database
        $user_id = $_SESSION['user_id']; // Assuming the user ID is stored in the session
        $sql = "SELECT password FROM users WHERE user_id = $user_id";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);

        // Verify the current password
        if (password_verify($current_password, $row['password'])) {
            // Hash the new password
            $new_password_hashed = password_hash($new_password, PASSWORD_DEFAULT);

            // Update the password in the database
            $update_sql = "UPDATE users SET password = '$new_password_hashed' WHERE user_id = $user_id";
            if (mysqli_query($conn, $update_sql)) {
                echo "Password changed successfully!";
            } else {
                echo "Error updating password: " . mysqli_error($conn);
            }
        } else {
            echo "Your current password is incorrect!";
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
    <title>Change Password</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <h2>Change Password</h2>
    <form action="change_password.php" method="POST">
        <label for="current_password">Current Password:</label>
        <input type="password" name="current_password" required><br>

        <label for="new_password">New Password:</label>
        <input type="password" name="new_password" required><br>

        <label for="confirm_password">Confirm New Password:</label>
        <input type="password" name="confirm_password" required><br>

        <input type="submit" value="Change Password">
    </form>

    <br><a href="volunteer_dashboard.php">Back to Dashboard</a>
</body>
</html>
