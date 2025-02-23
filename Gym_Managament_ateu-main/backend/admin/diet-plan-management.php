<?php
// Enable error reporting for debugging (remove in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

include '../config/db.php';
// Initialize messages
$success_message = "";
$error_message = "";

// Handle diet plan submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_diet_plan'])) {
    $user_id = $_POST['user_id'];
    $diet_type = $_POST['diet_type'];
    $meal_plan = $_POST['meal_plan'];
    $recommended_by = $_POST['recommended_by'];

    if (!empty($user_id) && !empty($diet_type) && !empty($meal_plan)) {
        // Prepare and execute the query to insert diet plan
        $query = "INSERT INTO diet_plans (user_id, diet_type, meal_plan, recommended_by) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        if ($stmt === false) {
            $error_message = "Error preparing statement: " . $conn->error;
        } else {
            $stmt->bind_param("isss", $user_id, $diet_type, $meal_plan, $recommended_by);
            if ($stmt->execute()) {
                $success_message = "Diet plan added successfully!";
            } else {
                $error_message = "Error executing query: " . $stmt->error;
            }
            $stmt->close();
        }
    } else {
        $error_message = "Please fill in all the fields.";
    }
}

// Fetch users (outside the POST handling)
$sql = "SELECT id, username FROM users ORDER BY username ASC";
$result = $conn->query($sql);

// Available diet types for the dropdown
$diet_types = ['Vegetarian', 'Keto', 'Vegan', 'Paleo', 'Mediterranean'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Diet Plan</title>
    <style>
/* General Styles */
body {
    font-family: 'Poppins', sans-serif;
    background-color: #f8f9fa;
    margin: 0;
    padding: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}

/* Container */
.container {
    width: 90%;
    max-width: 600px;
    background: white;
    padding: 50px;
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
    border-radius: 10px;
    text-align: center;
}

/* Heading */
h2, h3 {
    color: #333;
    margin-bottom: 15px;
}

/* Messages */
.message {
    padding: 12px;
    margin: 10px 0;
    border-radius: 5px;
    font-weight: bold;
    text-align: center;
}

.success {
    background-color: #d4edda;
    color: #155724;
    border-left: 5px solid #28a745;
}

.error {
    background-color: #f8d7da;
    color: #721c24;
    border-left: 5px solid #dc3545;
}

/* Table */
table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 15px;
}

th, td {
    padding: 12px;
    border: 1px solid #ddd;
    text-align: left;
}

th {
    background-color:rgb(0, 0, 0);
    color: white;
}

tr:nth-child(even) {
    background-color: #f9f9f9;
}

tr:hover {
    background-color: #f1f1f1;
}

/* Form Styling */
form {
    margin-top: 20px;
    text-align: left;
}

label {
    font-weight: 600;
    display: block;
    margin: 10px 0 5px;
}

select, textarea, input[type="text"] {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 16px;
    margin-top: 5px;
}

/* Textarea */
textarea {
    resize: vertical;
}

/* Button Styling */
button {
    background-color: #28a745;
    color: white;
    border: none;
    padding: 12px;
    font-size: 16px;
    font-weight: bold;
    border-radius: 5px;
    cursor: pointer;
    width: 100%;
    transition: background 0.3s ease-in-out;
}

button:hover {
    background-color: #218838;
}

/* Responsive Design */
@media (max-width: 768px) {
    .container {
        width: 95%;
        padding: 20px;
    }

    th, td {
        font-size: 14px;
        padding: 8px;
    }

    button {
        font-size: 14px;
        padding: 10px;
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

    <?php if (!empty($success_message)): ?>
        <div class="message success"><?php echo $success_message; ?></div>
    <?php endif; ?>
    

    <?php if (!empty($error_message)): ?>
        <div class="message error"><?php echo $error_message; ?></div>
    <?php endif; ?>
    <h2>Create Diet Plan</h2>
    <form method="POST" action="">
        <table>
            <tr>
                <th>Select User</th>
                <th>User ID</th>
                <th>Username</th>
            </tr>
            <?php if ($result && $result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td>
                            <input type="radio" name="user_id" value="<?php echo htmlspecialchars($row['id']); ?>" required>
                        </td>
                        <td><?php echo htmlspecialchars($row['id']); ?></td>
                        <td><?php echo htmlspecialchars($row['username']); ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="3">No users found.</td></tr>
            <?php endif; ?>
        </table>

        <h3>Diet Plan Details</h3>
        <label for="diet_type">Diet Type:</label><br>
        <select id="diet_type" name="diet_type" required>
            <option value="">Select Diet Type</option>
            <?php foreach ($diet_types as $diet): ?>
                <option value="<?php echo htmlspecialchars($diet); ?>"><?php echo htmlspecialchars($diet); ?></option>
            <?php endforeach; ?>
        </select><br><br>

        <label for="meal_plan">Meal Plan:</label><br>
        <textarea id="meal_plan" name="meal_plan" rows="5" required></textarea><br><br>

        <label for="recommended_by">Recommended By (Optional):</label><br>
        <input type="text" id="recommended_by" name="recommended_by"><br><br>

        <button type="submit" name="submit_diet_plan">Save Diet Plan</button>
    </form>
            </div>
    <?php $conn->close(); ?>
</body>
</html>
