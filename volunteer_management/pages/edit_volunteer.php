<?php
// Include the database connection file
include '../includes/db_connect.php';


// Get the volunteer ID from the URL
$volunteer_id = $_GET['id'];

// Fetch the volunteer data based on the ID
$sql = "SELECT * FROM volunteers WHERE volunteer_id = $volunteer_id";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    $volunteer = mysqli_fetch_assoc($result);
} else {
    echo "Volunteer not found!";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<a href="logout.php" class="button logout-button">Logout</a>
<br><a href="admin_dashboard.php" class=button>Back to Admin Dashboard</a>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Volunteer</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <h2>Edit Volunteer</h2>

    <form action="update_volunteer.php" method="POST">
        <input type="hidden" name="volunteer_id" value="<?php echo $volunteer['volunteer_id']; ?>">

        <label for="first_name">First Name:</label>
        <input type="text" name="first_name" value="<?php echo $volunteer['first_name']; ?>" required><br>

        <label for="last_name">Last Name:</label>
        <input type="text" name="last_name" value="<?php echo $volunteer['last_name']; ?>" required><br>

        <label for="email">Email:</label>
        <input type="email" name="email" value="<?php echo $volunteer['email']; ?>" required><br>

        <label for="phone_number">Phone Number:</label>
        <input type="text" name="phone_number" value="<?php echo $volunteer['phone_number']; ?>" required><br>

        <label for="date_of_birth">Date of Birth:</label>
        <input type="date" name="date_of_birth" value="<?php echo $volunteer['date_of_birth']; ?>" required><br>

        <label for="address">Address:</label>
        <textarea name="address" required><?php echo $volunteer['address']; ?></textarea><br>

        <input type="submit" value="Update Volunteer">
    </form>

    <a href="view_volunteers.php">Back to Volunteers List</a>
</body>
</html>
