<?php
header('Content-Type: application/json');
require '../config/db.php';

// Fetch classes from the database
$sql = "SELECT id, class_name, trainer_name, schedule, max_capacity FROM classes";
$result = $conn->query($sql);

$classes = [];

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $classes[] = $row;
    }
    echo json_encode($classes);
} else {
    echo json_encode([]);
}

$conn->close();
?>
