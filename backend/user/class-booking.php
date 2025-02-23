<?php
session_start();
header('Content-Type: application/json');
include '../config/db.php';

// Debugging: Log request type
error_log("Request Method: " . $_SERVER["REQUEST_METHOD"]);
error_log("Raw Input: " . file_get_contents("php://input"));

// Ensure request is POST and user is logged in
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (!isset($_SESSION["user_id"])) {
        echo json_encode(["success" => false, "error" => "User not logged in"]);
        exit();
    }

    // Retrieve JSON input
    $input = json_decode(file_get_contents("php://input"), true);
    if (!isset($input["class_id"])) {
        echo json_encode(["success" => false, "error" => "Missing class ID"]);
        exit();
    }

    $user_id = $_SESSION["user_id"];
    $class_id = $input["class_id"];

    // Insert into bookings table
    $stmt = $conn->prepare("INSERT INTO bookings (user_id, class_id) VALUES (?, ?)");
    $stmt->bind_param("ii", $user_id, $class_id);

    if ($stmt->execute()) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "error" => $conn->error]);
    }
} else {
    echo json_encode(["success" => false, "error" => "Invalid request method"]);
}
?>
