<?php
session_start();
require '../config/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];  // Ensure user is logged in
    $trainer_name = $_POST['trainer_name'];
    $rating = $_POST['rating'];
    $comments = $_POST['comments'];

    // Insert feedback into the database
    $sql = "INSERT INTO feedback (user_id, trainer_name, rating, comments) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isis", $user_id, $trainer_name, $rating, $comments);
    
    if ($stmt->execute()) {
        echo "<script>alert('Feedback submitted successfully!'); window.location.href='../../frontend/user-dashboard.html';</script>";
    } else {
        echo "<script>alert('Error submitting feedback. Please try again.'); window.history.back();</script>";
    }

    $stmt->close();
    $conn->close();
}
?>
