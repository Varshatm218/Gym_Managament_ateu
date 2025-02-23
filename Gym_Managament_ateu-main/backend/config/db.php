<?php
$host = 'localhost';
$dbname = 'gym_management';  // Your database name
$username = 'root';          // Your database username
$password = '';              // Your database password

// Create a new connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
   
}
?>
