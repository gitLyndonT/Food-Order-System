<?php 

    // Include constants.php file for access to SITEURL and database connection
    include('../config/constants.php');

    // Get the ID of the Admin to be Deleted (this ID is passed as a query parameter)
    $id = $_GET['id'];  // The admin ID to be deleted is extracted from the URL

    // Create SQL Query to Delete the Admin based on the ID
    $sql = "DELETE FROM tbl_admin WHERE id=$id";  // SQL DELETE query

    // Execute the SQL Query to delete the admin
    $res = mysqli_query($conn, $sql);

    // Check if the query executed successfully
    if($res == TRUE) {
        // Query Executed Successfully, Admin Deleted

        // Create a session message to notify the user about successful deletion
        $_SESSION['delete'] = "<div class='success'>Admin Deleted Successfully.</div>";

        // Redirect to the Manage Admin page after deletion
        header('location:' . SITEURL . 'admin/manage-admin.php');
    } else {
        // Failed to delete admin

        // Set an error message to notify the user about the failure
        $_SESSION['delete'] = "<div class='error'>Failed to Delete Admin. Try Again Later.</div>";
        
        // Redirect back to the Manage Admin page with the error message
        header('location:' . SITEURL . 'admin/manage-admin.php');
    }

    // The process ends here with the redirection to manage-admin page
?>
