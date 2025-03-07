<!DOCTYPE html>
<html lang="en">
<a href="logout.php" class="button logout-button">Logout</a>
<br><a href="admin_dashboard.php" class=button>Back to Admin Dashboard</a>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Volunteer</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <h2>Add New Volunteer</h2>
    <form action="process_volunteer.php" method="POST">
        <label for="first_name">First Name:</label>
        <input type="text" name="first_name" required><br>

        <label for="last_name">Last Name:</label>
        <input type="text" name="last_name" required><br>

        <label for="email">Email:</label>
        <input type="email" name="email" required><br>

        <label for="phone_number">Phone Number:</label>
        <input type="text" name="phone_number" required><br>

        <label for="date_of_birth">Date of Birth:</label>
        <input type="date" name="date_of_birth" required><br>

        <label for="address">Address:</label>
        <textarea name="address" required></textarea><br>

        <input type="submit" value="Add Volunteer">
    </form>

    <a href="view_volunteers.php"class="button">View All Volunteers</a>
</body>
</html>
