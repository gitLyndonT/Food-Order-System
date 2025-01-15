<?php
    // Start the session at the top of the file
    session_start();
    include('../config/constants.php');

    // Display session messages
    if (isset($_SESSION['remove'])) {
        echo $_SESSION['remove'];
        unset($_SESSION['remove']);
    }
    if (isset($_SESSION['delete'])) {
        echo $_SESSION['delete'];
        unset($_SESSION['delete']);
    }

    // Check whether the id and image_name value is set or not
    if(isset($_GET['id']) AND isset($_GET['image_name']))
    {
        // Get the value and delete
        $id = $_GET['id'];
        $image_name = $_GET['image_name'];

        // Remove the image file
        if($image_name != "")
        {
            // Image is available, so let's remove it
            $path = "../images/category/".$image_name; 
            // Remove the image
            $remove = unlink($path);

            if($remove == FALSE)
            {
                // Set the session message
                $_SESSION['remove'] = "<div class='error'>Failed to Remove Category Image.</div>";
                header('location:'.SITEURL.'admin/manage-category.php');
                die();
            }
        }

        // Delete from the database
        $sql = "DELETE FROM tbl_category WHERE id=$id";
        
        $res = mysqli_query($conn, $sql);

        if($res == TRUE)
        {
            // Set success message
            $_SESSION['delete'] = "<div class='success'>Category Deleted Successfully.</div>";
            header('location:'.SITEURL.'admin/manage-category.php');
        }
        else
        {
            // Set fail message
            $_SESSION['delete'] = "<div class='error'>Failed to Delete Category.</div>";
            header('location:'.SITEURL.'admin/manage-category.php');
        }

    }
    else
    {
        // Redirect to manage category page if id and image_name are not set
        header('location:'.SITEURL.'admin/manage-category.php');    
    }
?>
