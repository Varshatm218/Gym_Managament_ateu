<?php
session_start();
session_destroy();
header("Location: http://localhost/gym_management_system/frontend/login.html");
exit();
?>
