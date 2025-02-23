
<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection configuration
$host = 'localhost';
$dbname = 'gym_management'; // Ensure this database exists
$username = 'root'; // Default username for XAMPP
$password = ''; // Default password for XAMPP (empty by default)

// Create a connection to the database
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Prepare a query to fetch the user by email
    $sql = "SELECT * FROM admins WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if a user with the given email exists
    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        // Verify the password
        if ($password == $row['password_hash']) {
            echo "Login successful! Welcome, " . $row['username'] . ".";
            header("Location: /gym_management_system/backend/functions/admin-function.php");
            exit();
        } else {
            echo "Invalid password. Please try again.";
        }
    } else {
        echo "No account found with this email.";
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <style>

/* Global styles */
body {
    font-family: 'Arial', sans-serif;
    background-color: #f4f4f4;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
    flex-direction: column; /* Ensure elements are stacked properly */
    padding-top: 80px; /* Prevent overlap with fixed header */
}

/* Fixed Header */
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

/* Login Container */
.login-container {
    background: white;
    padding: 25px;
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    width: 320px;
    text-align: center;
    margin-top: 100px; /* Increased spacing */
}


/* Headings */
h2 {
    margin-bottom: 20px;
    color: #333;
}

/* Input Groups */
.input-group {
    margin-bottom: 15px;
    text-align: left;
}

.input-group label {
    display: block;
    margin-bottom: 6px;
    font-weight: bold;
    color: #555;
}

.input-group input {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 14px;
}

/* Login Button */
.login-button {
    width: 100%;
    background: #000000;
    color: white;
    padding: 12px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
    transition: background 0.3s ease-in-out;
}

.login-button:hover {
    background: #ec6e06;
}

/* Responsive Design */
@media (max-width: 400px) {
    .login-container {
        width: 90%;
    }
}
/* Ensure the body takes up full height */
html, body {
    height: 100%;
    margin: 0;
    display: flex;
    flex-direction: column;
}

/* Pushes content to fill the space */
body {
    flex: 1;
    display: flex;
    flex-direction: column;
}

/* Main content should take up all available space */
.main-content {
    flex: 1;
}

/* Footer styles */
footer {

    background: #333; /* Adjust as needed */
    color: white;
    text-align: center;
   
    width: 100%;
}




</style>
   
</head>
<header>
<?php
 include "header.php"
 ?>
 </header>
<body>

<div class="login-container">
    <h2>Admin Login</h2>
    <form method="POST">
        <div class="input-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
        </div>
        <div class="input-group">
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
        </div>
        <button type="submit" class="login-button">Login</button>
    </form>
</div>

</body>
<footer>
<?php
 include "footer.php"
 ?>
 </footer>
</html>
