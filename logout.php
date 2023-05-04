<?php
// Start the session
session_start();

// Clear the session ID cookie
setcookie('session_id', '', time() - 3600, "/");

// Redirect the user to the login page
header('Location: ./');
exit;
?>
