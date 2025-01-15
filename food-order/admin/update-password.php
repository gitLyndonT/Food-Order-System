<?php include('partails/menu.php'); ?>

<!-- Main Content Section Starts -->
<div class="main-content">
    <div class="wrapper">
        <h1>Change Password</h1>

        <br><br>

        <?php 
            if(isset($_GET['id'])) 
            {
                $id=$_GET['id'];
            }
        ?>

        <!-- Change Password Form -->
        <form action="" method="POST">

            <table class="tbl-30">
                <tr>
                    <td>Current Password: </td>
                    <td>
                        <input type="password" name="current_password" placeholder="Current Password" required>
                    </td>
                </tr>

                <tr>
                    <td>New Password: </td>
                    <td>
                        <input type="password" name="new_password" placeholder="New Password" required>
                    </td>
                </tr>

                <tr>
                    <td>Confirm Password: </td>
                    <td>
                        <input type="password" name="confirm_password" placeholder="Confirm Password" required>
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="submit" name="submit" value="Change Password" class="btn-primary">
                    </td>
                </tr>

            </table>

        </form>
        <!-- End of Change Password Form -->

    </div>
</div>
<!-- Main Content Section Ends -->

<?php 
    // Check if Submit Button is clicked
    if(isset($_POST['submit'])) 
    {
        // Get Data from Form
        $id = $_POST['id'];
        $current_password = md5($_POST['current_password']);
        $new_password = md5($_POST['new_password']);
        $confirm_password = md5($_POST['confirm_password']);

        // Check if current password matches
        $sql = "SELECT * FROM tbl_admin WHERE id=$id AND password='$current_password'";

        $res = mysqli_query($conn, $sql);

        if($res == TRUE) {
            // Check if data is found
            $count = mysqli_num_rows($res);

            if($count == 1) {
                // User exists, proceed with password change

                // Check if new password and confirm password match
                if($new_password == $confirm_password) 
                {
                    // Update password in the database
                    $sql2 = "UPDATE tbl_admin SET password='$new_password' WHERE id=$id";
                    $res2 = mysqli_query($conn, $sql2);

                    if($res2 == TRUE) 
                    {
                        // Success: Password changed
                        $_SESSION['change-pwd'] = "<div class='success'>Password Changed Successfully.</div>";
                        header('location:' . SITEURL . 'admin/manage-admin.php');
                    } 
                    else 
                    {
                        // Error: Failed to change password
                        $_SESSION['change-pwd'] = "<div class='error'>Failed to Change Password.</div>";
                        header('location:' . SITEURL . 'admin/manage-admin.php');
                    }
                } 
                else 
                {
                    // Error: Passwords do not match
                    $_SESSION['pwd-not-match'] = "<div class='error'>Passwords Did Not Match.</div>";
                    header('location:' . SITEURL . 'admin/manage-admin.php');
                }
            } 
            else 
            {
                // Error: User not found
                $_SESSION['user-not-found'] = "<div class='error'>User Not Found.</div>";
                header('location:' . SITEURL . 'admin/manage-admin.php');
            }
        }
    }
?>

<?php include('partails/footer.php'); ?>


<!-- CSS for Styling -->
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f9;
    }

    .tbl-30 {
        width: 100%;
        margin-top: 20px;
        border-collapse: collapse;
    }

    .tbl-30 td {
        padding: 12px;
        border: 1px solid #ddd;
    }

    .tbl-30 input[type="password"] {
        width: 100%;
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 4px;
        font-size: 16px;
    }

    input[type="submit"].btn-primary {
        background-color: #007bff;
        color: white;
        border: none;
        padding: 12px 25px;
        border-radius: 5px;
        font-size: 16px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    input[type="submit"].btn-primary:hover {
        background-color: #0056b3;
    }

    .success {
        background-color: #28a745;
        color: white;
        padding: 10px;
        margin-bottom: 15px;
        border-radius: 5px;
        text-align: center;
    }

    .error {
        background-color: #dc3545;
        color: white;
        padding: 10px;
        margin-bottom: 15px;
        border-radius: 5px;
        text-align: center;
    }

    .main-content {
        padding: 40px 20px;
        max-width: 700px;
        margin: 50px auto;
        background-color: white;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .wrapper {
        max-width: 600px;
        margin: 0 auto;
    }

    h1 {
        text-align: center;
        color: #333;
    }

    input[type="password"] {
        width: 100%;
        padding: 10px;
        border-radius: 4px;
        border: 1px solid #ccc;
        font-size: 16px;
        margin-bottom: 10px;
    }

    input[type="password"]:focus {
        border-color: #007bff;
    }

    input[type="submit"] {
        width: 100%;
        padding: 12px 25px;
        background-color: #007bff;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 16px;
    }

    input[type="submit"]:hover {
        background-color: #0056b3;
    }

    .wrapper {
        margin-top: 40px;
    }
</style>
