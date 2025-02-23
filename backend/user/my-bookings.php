<?php
session_start();
header('Content-Type: application/json');
require '../config/db.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode([]); // Return empty array if user is not logged in
    exit;
}

$user_id = $_SESSION['user_id'];

// Fetch booked classes
$sql = "SELECT c.id, c.class_name, c.trainer_name, c.schedule 
        FROM bookings b
        JOIN classes c ON b.class_id = c.id
        WHERE b.user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$booked_classes = [];
while ($row = $result->fetch_assoc()) {
    $booked_classes[] = $row;
}

echo json_encode($booked_classes);
$stmt->close();
$conn->close();
?>
