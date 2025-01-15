<?php
    // Start the session only if it is not already active
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    // Authorization 
    // Check whether the user is logged in or not
    if(!isset($_SESSION['user']))
    {
        // User is not logged in
        // Redirect to login page with message
        $_SESSION['no-login-message'] = "<div class='error'>Please login to access the Admin Panel</div>";

        // Redirect to login page
        header('location:' . SITEURL . 'admin/login.php');
        exit; // Good practice to call exit after a redirect
    }
?>
