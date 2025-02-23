<?php
// Include the database connection
include '../config/db.php';

// Initialize message variables
$success_message = "";
$error_message = "";

// Handle form submission to schedule a new class
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['schedule_class'])) {
    $class_name = $_POST["class_name"];
    $trainer_name = $_POST["trainer_name"];
    $schedule = $_POST["schedule"];
    $max_capacity = $_POST["max_capacity"];

    // Validate inputs
    if (!empty($class_name) && !empty($trainer_name) && !empty($schedule) && !empty($max_capacity)) {
        // Insert class into the database
        $stmt = $conn->prepare("INSERT INTO classes (class_name, trainer_name, schedule, max_capacity) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sssi", $class_name, $trainer_name, $schedule, $max_capacity);

        if ($stmt->execute()) {
            $success_message = "Class scheduled successfully!";
        } else {
            $error_message = "Error scheduling class: " . $stmt->error;
        }
        $stmt->close();
    } else {
        $error_message = "Please fill in all fields.";
    }
}

// Handle class deletion
if (isset($_GET['delete_class'])) {
    $class_id = $_GET['delete_class'];
    $stmt = $conn->prepare("DELETE FROM classes WHERE id = ?");
    $stmt->bind_param("i", $class_id);
    if ($stmt->execute()) {
        $success_message = "Class deleted successfully!";
    } else {
        $error_message = "Error deleting class: " . $stmt->error;
    }
    $stmt->close();
}

// Fetch all scheduled classes with optional filtering
$where_conditions = "WHERE 1";
if (isset($_GET['search'])) {
    $search_term = $_GET['search'];
    $where_conditions = "WHERE class_name LIKE ? OR trainer_name LIKE ?";
    $stmt = $conn->prepare("SELECT id, class_name, trainer_name, schedule, max_capacity, created_at FROM classes $where_conditions ORDER BY schedule ASC");
    $search_term = "%$search_term%";
    $stmt->bind_param("ss", $search_term, $search_term);
} else {
    $stmt = $conn->prepare("SELECT id, class_name, trainer_name, schedule, max_capacity, created_at FROM classes ORDER BY schedule ASC");
}

// Execute the query
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Class Scheduling</title>
    

    <style>
     /* General Page Styling */
body {
    font-family: Arial, sans-serif;
    background-color: #f8f9fa;
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;
    padding: 20px;
    margin: 0;
}

/* Headings */
h2 {
    color: #333;
    margin-bottom: 20px;
}

/* Table Styling */
table {
    width: 90%;
    border-collapse: collapse;
    background: white;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

th, td {
    border: 1px solid #ddd;
    padding: 12px;
    text-align: left;
}

th {
    background-color: #007bff;
    color: white;
    text-transform: uppercase;
}

tr:nth-child(even) {
    background-color: #f2f2f2;
}

tr:hover {
    background-color: #e9ecef;
}

/* Form Styling */
form {
    width: 50%;
    background: white;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    margin-bottom: 20px;
}

label {
    font-weight: bold;
}

input, button {
    width: 100%;
    padding: 10px;
    margin: 10px 0;
    border: 1px solid #ccc;
    border-radius: 5px;
}

input:focus {
    border-color: #007bff;
    outline: none;
}

/* Button Styling */
button {
    background-color: #28a745;
    color: white;
    font-size: 16px;
    cursor: pointer;
    border: none;
    transition: 0.3s;
}

button:hover {
    background-color: #218838;
}

/* Search Bar */
.search-bar {
    width: 50%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    margin-bottom: 15px;
}

/* Message Styling */
.message {
    padding: 12px;
    border-radius: 5px;
    width: 50%;
    text-align: center;
    margin-bottom: 15px;
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

/* Delete Link Styling */
a {
    color: #dc3545;
    text-decoration: none;
    font-weight: bold;
}

a:hover {
    text-decoration: underline;
}
   table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .message {
            padding: 10px;
            margin-top: 10px;
            border-radius: 5px;
        }
        .success {
            background-color: #d4edda;
            color: #155724;
        }
        .error {
            background-color: #f8d7da;
            color: #721c24;
        }
        .input-field, .input-date, .input-number {
            width: 80%;
            padding: 8px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .textarea-field {
            width: 80%;
            height: 30px;
            padding: 8px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .search-bar {
            width: 80%;
            padding: 8px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
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
    <h2>Schedule a Class</h2>

    <!-- Success or Error Message -->
    <?php if (!empty($success_message)): ?>
        <div class="message success"><?php echo $success_message; ?></div>
    <?php endif; ?>

    <?php if (!empty($error_message)): ?>
        <div class="message error"><?php echo $error_message; ?></div>
    <?php endif; ?>

    <!-- Form to Schedule Class -->
    <form method="POST">
        <label for="class_name">Class Name:</label><br>
        <input type="text" name="class_name" id="class_name" class="textarea-field" required><br>

        <label for="trainer_name">Trainer Name:</label><br>
        <input type="text" name="trainer_name" id="trainer_name" class="textarea-field" required><br>

        <label for="schedule">Schedule Date and Time:</label><br>
        <input type="datetime-local" name="schedule" id="schedule" class="input-date" required><br>

        <label for="max_capacity">Maximum Capacity:</label><br>
        <input type="number" name="max_capacity" id="max_capacity" class="input-number" required><br>

        <button type="submit" name="schedule_class" class="input-field">Schedule Class</button>
    </form>

    <h2>Scheduled Classes</h2>

    <!-- Search Bar -->
    <form method="GET">
        <input type="text" name="search" class="search-bar" placeholder="Search by class or trainer" value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
        <button type="submit">Search</button>
    </form>

    <?php if ($result->num_rows > 0): ?>
        <table>
            <tr>
                <th>Class Name</th>
                <th>Trainer Name</th>
                <th>Schedule</th>
                <th>Max Capacity</th>
                <th>Created At</th>
                <th>Actions</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['class_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['trainer_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['schedule']); ?></td>
                    <td><?php echo htmlspecialchars($row['max_capacity']); ?></td>
                    <td><?php echo htmlspecialchars($row['created_at']); ?></td>
                    <td>
                        <a href="?delete_class=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this class?')">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p>No scheduled classes found.</p>
    <?php endif; ?>

    <?php $conn->close(); ?>
</body>
</html>
