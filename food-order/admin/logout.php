<?php
// Include constants.php for SITEURL
include('../config/constants.php');
session_start(); // Start the session to manage session variables

// Destroy the session to log the user out
session_destroy();

// Set the session logout message
$_SESSION['logout'] = "<div class='success'>You have logged out successfully!</div>";

// Redirect to Login Page
header('location:' . SITEURL . 'admin/login.php');
exit; // Ensure no further code is executed after redirect
?>
