<?php
header('Content-Type: application/json');
require '../config/db.php';

session_start();
if (!isset($_SESSION['user_id'])) {
    echo json_encode(["error" => "User not logged in"]);
    exit();
}

$user_id = $_SESSION['user_id'];

$sql = "SELECT diet_type, meal_plan, recommended_by FROM diet_plans WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$diet_plans = [];

while ($row = $result->fetch_assoc()) {
    $diet_plans[] = $row;
}

echo json_encode($diet_plans);
$stmt->close();
$conn->close();
?>
