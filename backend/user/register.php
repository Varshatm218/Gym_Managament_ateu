<?php
require '../config/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
    $height = $_POST["height"];
    $weight = $_POST["weight"];
    $fitness_goals = $_POST["fitness_goals"];

    // Insert user data
    $sql = "INSERT INTO users (username, email, password, height, weight, fitness_goals) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", $username, $email, $password, $height, $weight, $fitness_goals);

    if ($stmt->execute()) {
        echo "<script>alert('Registration successful! Please login.'); window.location.href='http://localhost/gym_management_system/frontend/login.html';</script>";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
