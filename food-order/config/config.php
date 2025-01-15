<?php
// Define constants for connection settings
define('SITEURL', 'http://localhost/food-order/');   // Base URL of the site
define('LOCALHOST', 'localhost');                    // Database server (localhost for local development)
define('DB_USERNAME', 'root');                       // Database username (root for local development)
define('DB_PASSWORD', '');                           // Database password (empty for local development)
define('DB_NAME', 'food-order');                     // Name of the database

// Create a connection to the database
$conn = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Check the connection and show an error if it fails
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// If the connection is successful, this line is not reached
// mysqli_select_db is unnecessary here as mysqli_connect already selects the database
?>
