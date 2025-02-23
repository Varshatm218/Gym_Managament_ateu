<?php
session_start();
require '../config/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch the diet plan for the logged-in user
$sql = "SELECT diet_type, meal_plan, recommended_by FROM diet_plans WHERE user_id = ?";
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
    <title>Diet Plan</title>
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
        .diet-plan {
            background: #fff;
            padding: 15px;
            margin: 15px 0;
            border-radius: 8px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
            text-align: left;
        }
        h3 {
            color: #e67e22;
            margin-bottom: 10px;
        }
        p {
            margin: 5px 0;
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
        <h2>Your Diet Plan</h2>
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="diet-plan">
                    <h3>Diet Type: <?php echo htmlspecialchars($row['diet_type']); ?></h3>
                    <p><strong>Meal Plan:</strong> <?php echo nl2br(htmlspecialchars($row['meal_plan'])); ?></p>
                    <p><strong>Recommended By:</strong> <?php echo htmlspecialchars($row['recommended_by']); ?></p>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No diet plan assigned yet.</p>
        <?php endif; ?>
        
        <a href="../../frontend/user-dashboard.html" class="back-link">Back to Dashboard</a>
    </div>

</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
