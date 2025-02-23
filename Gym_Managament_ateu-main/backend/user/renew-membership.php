<?php
session_start();
require '../config/db.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'User not logged in']);
    exit;
}

$user_id = $_SESSION['user_id'];

// Check if the user has an existing membership
$sql = "SELECT end_date FROM memberships WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    $new_start_date = date('Y-m-d'); // Today's date
    $new_end_date = date('Y-m-d', strtotime('+1 month', strtotime($new_start_date)));

    // Update the membership
    $update_sql = "UPDATE memberships SET start_date = ?, end_date = ?, payment_status = 'paid' WHERE user_id = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("ssi", $new_start_date, $new_end_date, $user_id);
    
    if ($update_stmt->execute()) {
        echo json_encode(['message' => 'Membership renewed successfully!']);
    } else {
        echo json_encode(['error' => 'Failed to renew membership']);
    }

    $update_stmt->close();
} else {
    echo json_encode(['error' => 'No membership found']);
}

$stmt->close();
$conn->close();
?>
