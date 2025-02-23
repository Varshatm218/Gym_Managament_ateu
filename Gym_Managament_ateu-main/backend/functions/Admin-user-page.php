<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin & User Login</title>
    <style>
        /* Global styles */
        body {
            font-family: 'Arial', sans-serif;
            background: url('https://pngimg.com/uploads/fitness/fitness_PNG45.png') no-repeat center center/cover;
            height: 100vh;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            padding-top: 80px; /* Prevent overlap with header */
            position: relative;
        }

        /* Dark overlay for better readability */
        body::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.6); /* Dark overlay */
            z-index: 1;
        }

        /* Fixed Header */
        header {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            background: rgba(0, 0, 0, 0.8); /* Dark transparent header */
            color: white;
            text-align: center;
            font-size: 20px;
            padding: 15px 0;
            z-index: 1000;
        }

        /* Login Container */
        .login-container {
            background: rgba(255, 255, 255, 0.9); /* Slight transparency */
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            width: 350px;
            text-align: center;
            position: relative;
            z-index: 2; /* Above the overlay */
        }

        /* Headings */
        h2 {
            color: #222;
            margin-bottom: 20px;
            font-size: 22px;
        }

        /* Buttons */
        .btn {
            display: block;
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            font-size: 16px;
            font-weight: bold;
            color: white;
            background: #000; /* Black button */
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s ease-in-out;
            text-decoration: none;
        }

        .btn:hover {
            background: #ec6e06; /* Hover effect */
        }

        /* Footer styles */
        footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            background: rgba(0, 0, 0, 0.8);
            color: white;
            text-align: center;
            padding: 10px;
            z-index: 1000;
        }

        /* Responsive Design */
        @media (max-width: 400px) {
            .login-container {
                width: 90%;
            }
        }
    </style>
</head>
<body>

    <header>
        <img src="frontend/assets/logo.png" alt="Fit Physic Logo" class="logo">
    </header>

    <div class="login-container">
        <h2>Select Your Role</h2>
        <a href="/gym_management_system/backend/admin/admin-login.php" class="btn">Admin</a>
        <a href="/gym_management_system/frontend/login.html" class="btn">User</a>
    </div>

</body>
</html>
