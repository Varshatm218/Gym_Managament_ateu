<?php
session_start();
require '../config/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    $sql = "SELECT id, username, password FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($id, $username, $hashed_password);
    $stmt->fetch();

    if ($stmt->num_rows > 0 && password_verify($password, $hashed_password)) {
        $_SESSION["user_id"] = $id;
        $_SESSION["username"] = $username;
        
        echo "<script>alert('Login successful!'); window.location.href='http://localhost/gym_management_system/frontend/user-dashboard.html';</script>";
    } else {
        echo "<script>alert('Invalid email or password.'); window.location.href='http://localhost/gym_management_system/backend/user/login.php';</script>";
    }

    $stmt->close();
    $conn->close();
}
?>
