<?php
// Include database connection
include '../config/db.php';

// Query to fetch feedbacks along with user details
$sql = "SELECT feedback.id, users.username, feedback.trainer_name, feedback.rating, feedback.comments, feedback.submitted_at 
        FROM feedback 
        JOIN users ON feedback.user_id = users.id
        ORDER BY feedback.submitted_at DESC";

// Execute the query
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Feedbacks</title>
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
    max-width: 1000px;
    margin: 0 auto;
    background: #fff;
    padding: 50px;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

/* Heading */
h2 {
    text-align: center;
    color: #333;
}

/* Table Styling */
table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

th, td {
    padding: 12px;
    text-align: left;
    border: 1px solid #ddd;
}

th {
    background:rgb(0, 0, 0);
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
    .container {
        padding: 10px;
    }
    table {
        font-size: 14px;
    }
}

header {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    background: #333; /* Change as needed */
    color: white;
 
    text-align: center;
    font-size: 18px;
    z-index: 1000;
}

    </style>
</head>
<header>
<?php
 include "header.php"
 ?>
 </header>
<body>
    <div class="container">
    <h2>User Feedbacks</h2>

    <table>
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Trainer Name</th>
            <th>Rating</th>
            <th>Comments</th>
            <th>Submitted At</th>
        </tr>

        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['id']); ?></td>
                    <td><?php echo htmlspecialchars($row['username']); ?></td>
                    <td><?php echo htmlspecialchars($row['trainer_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['rating']); ?></td>
                    <td><?php echo htmlspecialchars($row['comments']); ?></td>
                    <td><?php echo htmlspecialchars($row['submitted_at']); ?></td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="6">No feedbacks found.</td></tr>
        <?php endif; ?>
    </table>
        </div>
</body>
</html>

<?php
// Close the connection
$conn->close();
?>
