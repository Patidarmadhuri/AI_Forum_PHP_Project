<?php
session_start(); // Start the session

// Destroy all session data
session_unset();
session_destroy();

// Redirect to login page or home page
header('Location: /AI_Forum_PHP_Project/public/index.php'); // Redirect to homepage (ensure correct URL)
exit();
?>
