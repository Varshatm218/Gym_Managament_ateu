<?php
session_start();
require '../config/db.php';

$user_id = $_SESSION['user_id']; // Get logged-in user ID
$sql = "SELECT trainer_name, rating, comments, submitted_at FROM feedback WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Feedback</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css"> 

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
            text-align: center;
        }
        .container {
            max-width: 700px;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            color: black;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: center;
        }
        th {
            background-color: #e67e22;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .back-link {
            display: block;
            margin-top: 15px;
            color: #e67e22;
            text-decoration: none;
            font-weight: bold;
        }
        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>My Feedback</h2>
        <table>
            <tr>
                <th>Trainer</th>
                <th>Rating</th>
                <th>Comments</th>
                <th>Date</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['trainer_name']) ?></td>
                    <td><?= $row['rating'] ?></td>
                    <td><?= htmlspecialchars($row['comments']) ?></td>
                    <td><?= $row['submitted_at'] ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
        
        <a href="../../frontend/user-dashboard.html" class="back-link">Back to Dashboard</a>
    </div>

</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
