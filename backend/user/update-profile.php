<?php
session_start();
require '../config/db.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in']);
    exit;
}

$user_id = $_SESSION['user_id'];
$height = $_POST['height'];
$weight = $_POST['weight'];
$fitness_goals = $_POST['fitness_goals'];

$sql = "UPDATE users SET height = ?, weight = ?, fitness_goals = ? WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ddsi", $height, $weight, $fitness_goals, $user_id);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Profile updated successfully']);
} else {
    echo json_encode(['success' => false, 'message' => 'Profile update failed']);
}

$stmt->close();
$conn->close();
?>
