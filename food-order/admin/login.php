<?php
include('../config/constants.php');
session_start(); // Start the session at the beginning of the script

// Check if the form is submitted
if (isset($_POST['submit'])) {
    // Get data from POST
    $username = $_POST['username'];
    $password = md5($_POST['password']); // MD5 hashing the password for comparison

    // SQL query to check if the user exists
    $sql = "SELECT * FROM tbl_admin WHERE username='$username' AND password='$password'";

    // Execute the query
    $res = mysqli_query($conn, $sql);

    // Check the number of rows returned
    $count = mysqli_num_rows($res);

    if ($count == 1) {
        // User found, login successful
        $_SESSION['login'] = "<div class='success'>Login successful!</div>";
        $_SESSION['user'] = $username;

        // Redirect to Home Page
        header('location:' . SITEURL . 'admin/');
        exit; // Ensure no further code is executed after redirect
    } else {
        // Invalid credentials, login failed
        $_SESSION['login'] = "<div class='error'>Invalid username or password.</div>";
        header('location:' . SITEURL . 'admin/login.php');
        exit; // Ensure no further code is executed after redirect
    }
}
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Food Order System</title>
    <link rel="stylesheet" href="../css/admin.css">
</head>

<body>
    <!-- Login Section -->
    <div class="login">
        <h1 class="text-center">Login</h1>
        <br>

        <?php 
            // Display login message if available
            if (isset($_SESSION['login'])) {
                echo $_SESSION['login']; // Display message
                unset($_SESSION['login']); // Remove message after displaying it
            }
        ?>

        <br>
        <!-- Login Form -->
        <form action="" method="POST">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" placeholder="Enter Username" required>
            </div>

            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" placeholder="Enter Password" required>
            </div>

            <input type="submit" name="submit" value="Login" class="btn-primary">
        </form>
        <!-- End of Login Form -->

        <p class="text-center">Created By - <a href="https://www.daichi.com" target="_blank">Daichi Kyoto</a></p>
    </div>

</body>
</html>
