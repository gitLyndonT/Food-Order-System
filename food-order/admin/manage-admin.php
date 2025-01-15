<?php include('partails/menu.php'); ?>

<!-- Main Content Section Starts -->
<div class="main-content">
    <div class="wrapper">
        <h1>Manage Admin</h1>

        <br /><br />

        <?php
            if(isset($_SESSION['add']))
            {
                echo $_SESSION['add']; // Displaying Session Message
                unset($_SESSION['add']); // Removing Session Message
            }

            if(isset($_SESSION['delete'])) {
                echo $_SESSION['delete'];
                unset($_SESSION['delete']);
            }

            if(isset($_SESSION['update']))
            {
                echo $_SESSION['update'];
                unset($_SESSION['update']);
            }

            if(isset($_SESSION['user-not-found']))
            {
                echo $_SESSION['user-not-found'];
                unset($_SESSION['user-not-found']);
            }

            if(isset($_SESSION['pwd-not-match']))
            {
                echo $_SESSION['pwd-not-match'];
                unset($_SESSION['pwd-not-match']);
            }

            if(isset($_SESSION['change-pwd']))
            {
                echo $_SESSION['change-pwd'];
                unset($_SESSION['change-pwd']);
            }
        ?>
        <br><br>

        <!-- Button to Add Admin -->
        <a href="add-admin.php" class="btn-primary">Add Admin</a>

        <br /><br /><br />

        <table class="tbl-full">
            <tr>
                <th>S.N</th>
                <th>Full Name</th>
                <th>Username</th>
                <th>Actions</th>
            </tr>

            <?php
                //Query to Get all Admin
                $sql = "SELECT * FROM tbl_admin";
                $res = mysqli_query($conn, $sql);

                if($res == TRUE)
                {
                    // Count Rows to Check whether we have data in database or not
                    $count = mysqli_num_rows($res);

                    $sn=1;

                    // Check the num of rows
                    if($count>0)
                    {
                        //We have data in database
                        while($rows=mysqli_fetch_assoc($res))
                        {
                            //Get Individual Data
                            $id=$rows['id'];
                            $full_name=$rows['full_name'];
                            $username=$rows['username'];

                            //Display the Values in our Table
                            ?>
                            <tr>
                                <td><?php echo $sn++; ?>.</td>
                                <td><?php echo $full_name; ?></td>
                                <td><?php echo $username; ?></td>
                                <td>
                                    <a href="<?php echo SITEURL; ?>admin/update-password.php?id=<?php echo $id; ?>" class="btn-primary">Change Password</a>
                                    <a href="<?php echo SITEURL; ?>admin/update-admin.php?id=<?php echo $id; ?>" class="btn-secondary">Update Admin</a>
                                    <a href="<?php echo SITEURL; ?>admin/delete-admin.php?id=<?php echo $id; ?>" class="btn-danger">Delete Admin</a>
                                </td>
                            </tr>
                            <?php
                        }
                    }
                    else
                    {
                        
                    }
                }
            ?>
        </table>

    </div>
</div>
<!-- Main Content Section Ends -->

<?php include('partails/footer.php'); ?>

<!-- Include Font Awesome CDN -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<style>
    .main-content {
        background: #f5f5f5;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    h1 {
        font-size: 30px;
        color: #333;
        text-transform: uppercase;
        text-align: center;
        font-weight: bold;
    }

    .btn-primary, .btn-secondary, .btn-danger {
        text-decoration: none;
        padding: 10px 20px;
        border-radius: 5px;
        font-weight: bold;
        color: #fff;
        transition: all 0.3s;
    }

    .btn-primary {
        background-color: #5cb85c;
    }

    .btn-primary:hover {
        background-color: #4cae4c;
    }

    .btn-secondary {
        background-color: #f0ad4e;
    }

    .btn-secondary:hover {
        background-color: #ec971f;
    }

    .btn-danger {
        background-color: #d9534f;
    }

    .btn-danger:hover {
        background-color: #c9302c;
    }

    .tbl-full {
        width: 100%;
        border-collapse: collapse;
        margin-top: 30px;
    }

    .tbl-full th, .tbl-full td {
        padding: 12px;
        text-align: center;
        border-bottom: 1px solid #ddd;
    }

    .tbl-full th {
        background-color: #f8f8f8;
        font-weight: bold;
    }

    .tbl-full tr:hover {
        background-color: #f1f1f1;
    }

    .tbl-full tr:nth-child(odd) {
        background-color: #f9f9f9;
    }

    .tbl-full tr:nth-child(even) {
        background-color: #e9e9e9;
    }

    .message {
        padding: 10px;
        background-color: #e7f7e7;
        color: #5f9c5f;
        border-radius: 5px;
        margin-bottom: 20px;
    }

    .message.error {
        background-color: #f8d7da;
        color: #f44336;
    }

    .message.success {
        background-color: #d4edda;
        color: #28a745;
    }

    @media (max-width: 768px) {
        .tbl-full {
            font-size: 14px;
        }

        .main-content {
            padding: 20px;
        }

        h1 {
            font-size: 24px;
        }
    }
</style>
