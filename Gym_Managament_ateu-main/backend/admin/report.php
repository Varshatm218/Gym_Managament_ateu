<?php
// Include the database connection
include("../config/db.php");

// Fetch all users and their details
$stmt = $conn->prepare("SELECT id, username, email, height, weight, fitness_goals, role, created_at FROM users");
$stmt->execute();
$result = $stmt->get_result();

// Fetch total counts for statistics
$total_users_query = "SELECT COUNT(*) AS total_users FROM users";
$total_users_result = $conn->query($total_users_query);
$total_users = $total_users_result->fetch_assoc()['total_users'];

$total_admins_query = "SELECT COUNT(*) AS total_admins FROM users WHERE role = 'admin'";
$total_admins_result = $conn->query($total_admins_query);
$total_admins = $total_admins_result->fetch_assoc()['total_admins'];

$total_memberships_query = "SELECT COUNT(*) AS total_memberships FROM memberships";
$total_memberships_result = $conn->query($total_memberships_query);
$total_memberships = $total_memberships_result->fetch_assoc()['total_memberships'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Report</title>
    <style>
      /* General Styles */
body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    margin: 0;
    padding: 20px;
}

/* Container */
.container {
    max-width: 1200px;
    margin: 0 auto;
    background: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

/* Heading */
h2, h3 {
    text-align: center;
    color: #333;
}

/* Statistics Section */
.stats {
    display: flex;
    justify-content: space-around;
    padding: 20px;
    background: #007bff;
    color: white;
    border-radius: 8px;
    margin-bottom: 20px;
}

.stats p {
    font-size: 18px;
    font-weight: bold;
}

/* Table Styling */
table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

th, td {
    padding: 10px;
    text-align: left;
    border: 1px solid #ddd;
}

th {
    background: #007bff;
    color: white;
}

tr:nth-child(even) {
    background: #f2f2f2;
}

tr:hover {
    background: #ddd;
}

/* Responsive */
@media (max-width: 768px) {
    .stats {
        flex-direction: column;
        text-align: center;
    }
}

    </style>
</head>
<body>
    <div class="container">
    <h2>Admin Report</h2>

    <!-- Statistics Section -->
    <div class="stats">
        <h3>Statistics</h3>
        <p>Total Users: <?php echo $total_users; ?></p>
        <p>Total Admins: <?php echo $total_admins; ?></p>
        <p>Total Memberships: <?php echo $total_memberships; ?></p>
    </div>

    <!-- User Details Table -->
    <h3>User Details</h3>
    <?php if ($result->num_rows > 0): ?>
        <table>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Email</th>
                <th>Height</th>
                <th>Weight</th>
                <th>Fitness Goals</th>
                <th>Role</th>
                <th>Created At</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['id']); ?></td>
                    <td><?php echo htmlspecialchars($row['username']); ?></td>
                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                    <td><?php echo htmlspecialchars($row['height']); ?></td>
                    <td><?php echo htmlspecialchars($row['weight']); ?></td>
                    <td><?php echo htmlspecialchars($row['fitness_goals']); ?></td>
                    <td><?php echo htmlspecialchars($row['role']); ?></td>
                    <td><?php echo htmlspecialchars($row['created_at']); ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p>No users found.</p>
    <?php endif; ?>

    <?php
    // Close the statement and connection
    $stmt->close();
    $conn->close();
    ?>
    </div>
</body>
</html>
