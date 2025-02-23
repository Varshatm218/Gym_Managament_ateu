<?php
header("Content-Type: application/json; charset=UTF-8"); 
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
include '../config/db.php';


if (!isset($_SESSION['user_id'])) {
    die(json_encode(["success" => false, "message" => "User not logged in"]));
}

if (!isset($_POST['membership_type'])) {
    die(json_encode(["success" => false, "message" => "Membership type is required"]));
}

$user_id = $_SESSION['user_id'];
$membership_type = $_POST['membership_type'];
$start_date = date('Y-m-d');
$end_date = ($membership_type == "Monthly") ? date('Y-m-d', strtotime("+1 month")) :
           (($membership_type == "Quarterly") ? date('Y-m-d', strtotime("+3 months")) :
           date('Y-m-d', strtotime("+1 year")));
$payment_status = "paid";

$sql = "INSERT INTO memberships (user_id, membership_type, start_date, end_date, payment_status) 
        VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    die(json_encode(["success" => false, "message" => "SQL Error: " . $conn->error]));
}

$stmt->bind_param("issss", $user_id, $membership_type, $start_date, $end_date, $payment_status);

if ($stmt->execute()) {
    echo json_encode(["success" => true, "message" => "Membership purchased successfully!"]);
} else {
    die(json_encode(["success" => false, "message" => "Database error: " . $stmt->error]));
}

$stmt->close();
$conn->close();
?>
