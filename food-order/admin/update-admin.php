<?php include('partails/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update Admin</h1>

        <br><br>

        <?php 
            // Check if there's a session message to display
            if (isset($_SESSION['update'])) 
            {
                echo $_SESSION['update'];  // Display the success or error message
                unset($_SESSION['update']); // Clear the session message
            }

            // Get the ID of Selected Admin (this would act as the identifier)
            $id = $_GET['id'];  // We get the ID from the URL query parameter

            // SQL Query to Get the Admin Details for the given ID
            $sql = "SELECT * FROM tbl_admin WHERE id=$id";

            // Execute the SQL Query
            $res = mysqli_query($conn, $sql);

            // Check if the query was executed successfully
            if ($res == TRUE) {
                // Check if there is a matching record for the given admin ID
                $count = mysqli_num_rows($res);
                if ($count == 1) 
                {
                    // Fetch the Admin details
                    $rows = mysqli_fetch_assoc($res);

                    $full_name = $rows['full_name'];
                    $username = $rows['username'];
                } 
                else 
                {
                    // If admin data is not found, redirect back to the manage-admin page
                    header('location:' . SITEURL . 'admin/manage-admin.php');
                }
            }
        ?>

        <!-- Form for Updating Admin -->
        <form action="" method="POST">
            <table class="tbl-30">
                <!-- Full Name Input Field -->
                <tr>
                    <td>Full Name: </td>
                    <td>
                        <input type="text" name="full_name" value="<?php echo $full_name; ?>" required>
                    </td>
                </tr>

                <!-- Username Input Field -->
                <tr>
                    <td>Username: </td>
                    <td>
                        <input type="text" name="username" value="<?php echo $username; ?>" required>
                    </td>
                </tr>

                <!-- Hidden Input to Carry Admin ID for Update -->
                <tr>
                    <td colspan="2">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="submit" name="submit" value="Update Admin" class="btn-secondary">
                    </td>
                </tr>

            </table>
        </form>
    </div>    
</div>

<?php 

    // Check whether the Submit Button is Clicked (This is where form submission is processed)
    if (isset($_POST['submit'])) 
    {
        // Get all the values from the form to update
        $id = $_POST['id'];  // The Admin ID is passed as a hidden field
        $full_name = $_POST['full_name'];  // New full name entered by the user
        $username = $_POST['username'];  // New username entered by the user

        // SQL Query to Update the Admin details
        $sql = "UPDATE tbl_admin SET
        full_name = '$full_name',
        username = '$username'
        WHERE id='$id'";  // The WHERE condition makes sure the update is done for the correct admin

        // Execute the SQL Query
        $res = mysqli_query($conn, $sql);

        // Check if the query was executed successfully
        if ($res == TRUE) 
        {
            // Admin details updated successfully
            $_SESSION['update'] = "<div class='success'>Admin Updated Successfully.</div>";

            // Redirect to manage-admin page after successful update
            header('location:' . SITEURL . 'admin/manage-admin.php'); 
        } 
        else 
        {
            // If the update failed
            $_SESSION['update'] = "<div class='error'>Failed to Update Admin.</div>";
            // Redirect back to the manage-admin page after failure
            header('location:' . SITEURL . 'admin/manage-admin.php');
        }
    }
?>

<?php include('partails/footer.php'); ?>
