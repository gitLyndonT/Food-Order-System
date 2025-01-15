<?php
// Start the session
session_start();

// Include constants page
include('../config/constants.php');

if(isset($_GET['id']) AND isset($_GET['image_name'])) {
    // Process to delete
    // Get id and image name
    $id = $_GET['id'];
    $image_name = $_GET['image_name'];

    // Remove the image if available
    if($image_name != "") {
        // Get the image path
        $path = "../images/food/".$image_name;

        // Remove image file from folder
        $remove = unlink($path);

        // Check whether the image is removed or not
        if($remove == FALSE) {
            // Failed to remove image
            $_SESSION['upload'] = "<div class='error'>Failed to Remove Image File.</div>";
            header('location:'.SITEURL.'admin/manage-food.php');
            die();
        }
    }

    // Delete food from database
    $sql = "DELETE FROM tbl_foods WHERE id=?";
    
    // Prepare the query
    if($stmt = mysqli_prepare($conn, $sql)) {
        // Bind parameters
        mysqli_stmt_bind_param($stmt, "i", $id);

        // Execute the query
        $res = mysqli_stmt_execute($stmt);

        // Check if the query was successful
        if($res == TRUE) {
            // Food deleted
            $_SESSION['delete'] = "<div class='success'>Food Deleted Successfully.</div>";
            header('location:'.SITEURL.'admin/manage-food.php');
        } else {
            // Failed to delete food
            $_SESSION['delete'] = "<div class='error'>Failed to Delete Food. " . mysqli_error($conn) . "</div>";
            header('location:'.SITEURL.'admin/manage-food.php');
        }
    } else {
        // Error preparing the statement
        $_SESSION['delete'] = "<div class='error'>Error in preparing query: " . mysqli_error($conn) . "</div>";
        header('location:'.SITEURL.'admin/manage-food.php');
    }
} else {
    // Redirect to manage food page
    $_SESSION['unauthorize'] = "<div class='error'>Unauthorized Access.</div>";
    header('location:'.SITEURL.'admin/manage-food.php');
}
?>
