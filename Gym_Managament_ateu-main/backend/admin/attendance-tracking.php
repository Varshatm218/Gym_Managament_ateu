<?php
// Enable error reporting for debugging (remove in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection
$host = 'localhost';
$dbname = 'gym_management';
$username = 'root';
$password = '';
$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize messages
$success_message = "";
$error_message = "";

// Handle attendance submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['attendance'])) {
    if (!empty($_POST['attendance'])) {
        $conn->begin_transaction();
        try {
            $date = date('Y-m-d'); // Get the current date in YYYY-MM-DD format
            foreach ($_POST['attendance'] as $userId) {
                // Insert attendance with current date
                $attendanceQuery = "INSERT INTO attendance (user_id, check_in, date) VALUES (?, NOW(), ?)";
                $stmt = $conn->prepare($attendanceQuery);
                if ($stmt === false) {
                    throw new Exception("Error preparing statement: " . $conn->error);
                }
                $stmt->bind_param("is", $userId, $date); // 's' for string type (date), 'i' for integer (user_id)
                if (!$stmt->execute()) {
                    throw new Exception("Error executing query: " . $stmt->error);
                }
                $stmt->close(); // Close the statement
            }
            $conn->commit();
            $success_message = "Attendance recorded successfully!";
        } catch (Exception $e) {
            $conn->rollback();
            $error_message = "Error occurred: " . $e->getMessage();
        }
    } else {
        $error_message = "No users selected for attendance.";
    }
}

// Fetch users (outside the POST handling)
$sql = "SELECT id, username FROM users ORDER BY username ASC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mark Attendance</title>
    <style>
     /* General Body Styling */
body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
    flex-direction: column;
}

/* Page Heading */
h2 {
    color: #333;
    margin-bottom: 20px;
}

/* Table Styling */
table {
    width: 80%;
    border-collapse: collapse;
    background: white;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

th, td {
    border: 1px solid #ddd;
    padding: 12px;
    text-align: left;
}

th {
    background-color: #333;
    color: white;
    text-transform: uppercase;
}

tr:hover {
    background-color: #f1f1f1;
}

/* Message Styling */
.message {
    padding: 12px;
    border-radius: 5px;
    margin-bottom: 15px;
    text-align: center;
    width: 60%;
}

.success {
    background-color: #d4edda;
    color: #155724;
    border: 1px solid #c3e6cb;
}

.error {
    background-color: #f8d7da;
    color: #721c24;
    border: 1px solid #f5c6cb;
}

/* Checkbox Alignment */
td input[type="checkbox"] {
    transform: scale(1.2);
}

/* Button Styling */
button {
    background-color: #28a745;
    color: white;
    border: none;
    padding: 12px 20px;
    cursor: pointer;
    border-radius: 5px;
    font-size: 16px;
    margin-top: 10px;
}

button:hover {
    background-color: #218838;
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
    <h2>Mark Attendance</h2>

    <?php if (!empty($success_message)): ?>
        <div class="message success"><?php echo $success_message; ?></div>
    <?php endif; ?>

    <?php if (!empty($error_message)): ?>
        <div class="message error"><?php echo $error_message; ?></div>
    <?php endif; ?>

    <form method="POST" >  
        <table>
            <tr>
                <th>Select</th>
                <th>User ID</th>
                <th>Username</th>
                <th>Attendance Date</th>
            </tr>
            <?php if ($result && $result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td>
                            <input type="checkbox" name="attendance[]" value="<?php echo htmlspecialchars($row['id']); ?>">
                        </td>
                        <td><?php echo htmlspecialchars($row['id']); ?></td>
                        <td><?php echo htmlspecialchars($row['username']); ?></td>
                        <td><?php echo date('Y-m-d'); // Display today's date for the user ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="4">No users found.</td></tr>
            <?php endif; ?>
        </table>
        <br>
        <button type="submit">Submit Attendance</button>
    </form>

    <?php $conn->close(); ?>
</body>
</html>
