<?php
session_start();
header('Content-Type: application/json');
require '../config/db.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'User not logged in']);
    exit;
}

$user_id = $_SESSION['user_id'];
$class_id = $_GET['class_id'] ?? null;

if (!$class_id) {
    echo json_encode(['error' => 'Class ID missing']);
    exit;
}

// Delete booking
$sql = "DELETE FROM bookings WHERE user_id = ? AND class_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $user_id, $class_id);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['error' => 'Failed to cancel booking']);
}

$stmt->close();
$conn->close();
?>
