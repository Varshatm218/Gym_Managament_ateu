<?php

include '../config/db.php';

$activeMembersQuery = "SELECT COUNT(*) AS active_members FROM memberships WHERE end_date >= CURDATE()";
$activeMembersResult = $conn->query($activeMembersQuery);
$activeMembers = $activeMembersResult->fetch_assoc()['active_members'];

$pendingBookingsQuery = "SELECT COUNT(*) AS pending_bookings FROM bookings";
$pendingBookingsResult = $conn->query($pendingBookingsQuery);
$pendingBookings = $pendingBookingsResult->fetch_assoc()['pending_bookings'];

$feedbackQuery = "SELECT COUNT(*) AS new_feedback FROM feedback";
$feedbackResult = $conn->query($feedbackQuery);
$newFeedback = $feedbackResult->fetch_assoc()['new_feedback'];

?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      display: flex;
      min-height: 100vh;
      margin: 0;
      padding-top:30px;
    }
    .sidebar {
      width: 250px;
      background-color:rgb(0, 2, 9);
      color: white;
      padding: 20px;
    }
    .sidebar a {
      display: block;
      color: white;
      padding: 10px;
      text-decoration: none;
    }
    .sidebar a:hover {
      background-color:rgb(230, 220, 220);
    }
    .main-content {
      flex-grow: 1;
      padding: 30px;
      background-color: #f5f7fa;
    }
    .card {
      background-color: white;
      padding: 20px;
      border-radius: 12px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      margin-bottom: 20px;
    }
    header {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    background: #333; /* Change as needed */
    color: white;
 
    text-align: center;
    font-size: 18px;
    z-index: 1000;
}
  </style>
</head>
<header>
<?php
 include "../admin/header.php"
 ?>
 </header>
<body>
  <div class="sidebar">
    <h2>Dashboard</h2>
<a href="/gym_management_system/backend/admin/attendance-tracking.php">Attendance</a>
<a href="/gym_management_system/backend/admin/user-management.php">User Management</a>
<a href="/gym_management_system/backend/admin/membership-management.php">Membership</a>
<a href="/gym_management_system/backend/admin/booking.php">Booking</a>
<a href="/gym_management_system/backend/admin/diet-plan-management.php">Diet Plan</a>
<a href="/gym_management_system/backend/admin/feedback.php">Feedback</a>
<a href="/gym_management_system/backend/admin/logout.php">Logout</a>

  </div>
  <div class="main-content">
    <div class="card">
      <h2>Welcome to the Admin Dashboard</h2>
      <p>Manage activities, track attendance, update membership details, and more using the sidebar options.</p>
    </div>
    <div class="card">
      <h3>Quick Overview</h3>
      <ul>
        <li>Active Members: <?php echo $activeMembers; ?></li>
        <li>Pending Bookings: <?php echo $pendingBookings; ?></li>
        <li>New Feedback: <?php echo $newFeedback; ?></li>
      </ul>
    </div>
  </div>
</body>

</html>
