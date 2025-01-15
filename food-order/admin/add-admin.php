<?php 
    session_start();  // Start the session at the top of your script
    include('partails/menu.php'); 
?>

<!-- Main Content Section -->
<div class="main-content">
    <div class="wrapper">
        <h1>Add Admin</h1>

        <br><br>

        <?php 
            // Check if the 'add' session message is set, and display it with styling
            if(isset($_SESSION['add'])) {
                echo "<div class='success'>".$_SESSION['add']."</div>";
                unset($_SESSION['add']); // Remove the session message after displaying
            }
            // Check if the error session message is set
            if(isset($_SESSION['error'])) {
                echo "<div class='error'>".$_SESSION['error']."</div>";
                unset($_SESSION['error']); // Remove the error message after displaying
            }
        ?>
        <br><br>

        <!-- Add Admin Form -->
        <form action="" method="POST" class="admin-form">
            <table class="tbl-30">

                <!-- Full Name Input -->
                <tr>
                    <td>Full Name: </td>
                    <td>
                        <input type="text" name="full_name" placeholder="Enter Your Name" required>
                    </td>
                </tr>

                <!-- Username Input -->
                <tr>
                    <td>Username: </td>
                    <td>
                        <input type="text" name="username" placeholder="Enter Username" required>
                    </td>
                </tr>

                <!-- Password Input -->
                <tr>
                    <td>Password: </td>
                    <td>
                        <input type="password" name="password" placeholder="Your Password" required>
                    </td>
                </tr>

                <!-- Submit Button -->
                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Admin" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>
        <!-- Add Admin Form Ends -->

    </div>
</div>

<?php
    include('partails/footer.php'); 

    // Process the form when submitted
    // Process the form when submitted
    if(isset($_POST['submit'])) 
    {
        // Get form data
        $full_name = $_POST['full_name'];
        $username = $_POST['username'];
        $password = md5($_POST['password']);  // It's better to use password_hash for security

        // Insert the data into the database
        $sql = "INSERT INTO tbl_admin (full_name, username, password) 
                VALUES ('$full_name', '$username', '$password')";

        // Execute the query
        $res = mysqli_query($conn, $sql);

        // Check if the query executed successfully
        if($res == TRUE) {
            $_SESSION['add'] = "Admin Added Successfully.";
            header('location: ' . SITEURL . 'admin/manage-admin.php');
        } else {
            $_SESSION['error'] = "Failed to Add Admin.";
            header('location: ' . SITEURL . 'admin/add-admin.php');
        }
    }

?>
<!-- CSS for styling -->
<style>
    body {
        font-family: 'Arial', sans-serif;
        background-color: #f4f4f4;
        color: #333;
    }

    .admin-form {
        max-width: 700px;
        margin: 0 auto;
        padding: 30px;
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.1);
        animation: fadeIn 0.5s ease-in-out;
    }

    .admin-form h1 {
        font-size: 28px;
        margin-bottom: 25px;
        text-align: center;
        color: #4CAF50;
    }

    .tbl-30 {
        width: 100%;
        border-collapse: collapse;
    }

    .tbl-30 td {
        padding: 12px;
        text-align: left;
        font-size: 16px;
        vertical-align: middle;
    }

    .tbl-30 input {
        width: 100%;
        padding: 12px;
        font-size: 16px;
        border: 2px solid #ccc;
        border-radius: 6px;
        transition: all 0.3s ease-in-out;
        background-color: #f9f9f9;
    }

    .tbl-30 input:focus {
        border-color: #4CAF50;
        outline: none;
        background-color: #e8f5e9;
    }

    .btn-secondary {
        padding: 12px 24px;
        font-size: 18px;
        color: #fff;
        background-color: #4CAF50;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        transition: background-color 0.3s ease;
        display: block;
        width: 100%;
        margin-top: 20px;
    }

    .btn-secondary:hover {
        background-color: #388e3c;
    }

    .success, .error {
        text-align: center;
        padding: 12px;
        margin: 15px 0;
        font-size: 18px;
        border-radius: 6px;
    }

    .error {
        background-color: #f8d7da;
        color: #721c24;
    }

    .success {
        background-color: #d4edda;
        color: #155724;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .tbl-30 input:focus, .btn-secondary:hover {
        background-color: #e8f5e9;
    }

</style>  
