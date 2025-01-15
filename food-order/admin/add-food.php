<?php
    ob_start(); // Start output buffering
    session_start();
?>

<?php include('partails/menu.php'); ?>

<!-- Main Content Section -->
<div class="main-content">
    <div class="wrapper">
        <h1>Add Food</h1>

        <br><br>

        <?php
            // Display upload error or success message if any
            if(isset($_SESSION['upload']))
            {
                echo $_SESSION['upload'];
                unset($_SESSION['upload']);
            }
        ?>

        <!-- Form for Adding Food -->
        <form action="" method="POST" enctype="multipart/form-data" class="food-form">

            <table class="tbl-30">

                <!-- Title Input -->
                <tr>
                    <td>Title: </td>
                    <td>
                        <input type="text" name="title" placeholder="Title of the Food." required>
                    </td>
                </tr>

                <!-- Description Input -->
                <tr>
                    <td>Description: </td>
                    <td>
                        <textarea name="description" cols="30" rows="5" placeholder="Description of the Food." required></textarea>
                    </td>
                </tr>

                <!-- Price Input -->
                <tr>
                    <td>Price: </td>
                    <td>
                        <input type="number" name="price" required>
                    </td>
                </tr>

                <!-- Image Upload Input -->
                <tr>
                    <td>Select Image: </td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>

                <!-- Category Dropdown -->
                <tr>
                    <td>Category: </td>
                    <td>
                        <select name="category" required>
                            <?php
                                // Fetch active categories from the database
                                $sql = "SELECT * FROM tbl_category WHERE active='yes'";
                                $res = mysqli_query($conn, $sql);
                                $count = mysqli_num_rows($res);

                                if($count > 0)
                                {
                                    while($row = mysqli_fetch_assoc($res))
                                    {
                                        $id = $row['id'];
                                        $title = $row['title'];
                                        ?>
                                        <option value="<?php echo $id; ?>"><?php echo $title; ?></option>
                                        <?php
                                    }
                                }
                                else
                                {
                                    echo "<option value='0'>No Category Found</option>";
                                }
                            ?>
                        </select>
                    </td>
                </tr>

                <!-- Featured Option -->
                <tr>
                    <td>Featured: </td>
                    <td>
                        <input type="radio" name="featured" value="Yes" required> Yes
                        <input type="radio" name="featured" value="No" required> No
                    </td>
                </tr>

                <!-- Active Option -->
                <tr>
                    <td>Active: </td>
                    <td>
                        <input type="radio" name="active" value="Yes" required> Yes
                        <input type="radio" name="active" value="No" required> No
                    </td>
                </tr>

                <!-- Submit Button -->
                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Food" class="btn-secondary">
                    </td>
                </tr>

            </table>

        </form>

        <?php
            // Process the form when submitted
            if(isset($_POST['submit']))
            {
                // Retrieve form data
                $title = $_POST['title'];
                $description = mysqli_real_escape_string($conn, $_POST['description']); // Escape special characters
                $price = $_POST['price'];
                $category = $_POST['category'];

                // Handle featured and active fields
                $featured = isset($_POST['featured']) ? $_POST['featured'] : "Yes";
                $active = isset($_POST['active']) ? $_POST['active'] : "Yes";

                // Handle image upload
                $image_name = "";

                if(isset($_FILES['image']['name']) && $_FILES['image']['name'] != "")
                {
                    // Get the image name and extension
                    $image_name = $_FILES['image']['name'];
                    $image_ext = explode('.', $image_name); // Save in a variable
                    $ext = strtolower(end($image_ext)); // Use the variable

                    // Allowed extensions
                    $allowed_extensions = array('jpg', 'jpeg', 'png', 'gif');

                    // Validate image type
                    if(in_array($ext, $allowed_extensions))
                    {
                        // Generate a unique image name to avoid overwriting
                        $image_name = "Food-Name-".rand(0000,9999).".".$ext;

                        // Define the source and destination paths
                        $src = $_FILES['image']['tmp_name'];
                        $dst = "../images/food/".$image_name;

                        // Attempt to upload the image
                        $upload = move_uploaded_file($src, $dst);

                        // If upload fails, show error message and stop further execution
                        if($upload == FALSE)
                        {
                            $_SESSION['upload'] = "<div class='error'>Failed to Upload Image.</div>";
                            header('location:'.SITEURL.'admin/add-food.php');
                            exit();
                        }
                    }
                    else
                    {
                        $_SESSION['upload'] = "<div class='error'>Invalid Image Type. Only JPG, JPEG, PNG, GIF files are allowed.</div>";
                        header('location:'.SITEURL.'admin/add-food.php');
                        exit();
                    }
                }
                else
                {
                    $image_name = ""; // No image uploaded
                }

                // Insert the food into the database
                $sql2 = "INSERT INTO tbl_foods SET
                    title = '$title',
                    description = '$description',
                    price = $price,
                    image_name = '$image_name',
                    category_id = $category,
                    featured = '$featured',
                    active = '$active'
                ";

                $res2 = mysqli_query($conn, $sql2);

                if($res2 == TRUE)
                {
                    $_SESSION['add'] = "<div class='success'>Food Added Successfully.</div>";
                    header('location:'.SITEURL.'admin/manage-food.php');
                    exit();
                }
                else
                {
                    $_SESSION['add'] = "<div class='error'>Failed to Add Food.</div>";
                    header('location:'.SITEURL.'admin/manage-food.php');
                    exit();
                }
            }
        ?>
    </div>
</div>

<?php include('partails/footer.php'); ?>

<!-- CSS Styles for the Form -->
<style>
    body {
        font-family: 'Arial', sans-serif;
        background-color: #f4f4f4;
        color: #333;
    }

    .food-form {
        max-width: 700px;
        margin: 0 auto;
        padding: 30px;
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.1);
        animation: fadeIn 0.5s ease-in-out;
    }

    .food-form h1 {
        font-size: 28px;
        margin-bottom: 25px;
        text-align: center;
        color:rgb(56, 189, 60);
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

    .tbl-30 input, .tbl-30 select, .tbl-30 textarea {
        width: 100%;
        padding: 12px;
        font-size: 16px;
        border: 2px solid #ccc;
        border-radius: 6px;
        transition: all 0.3s ease-in-out;
        margin-top: 8px;
        background-color: #f9f9f9;
    }

    .tbl-30 input:focus, .tbl-30 select:focus, .tbl-30 textarea:focus {
        border-color:rgb(52, 199, 57);
        outline: none;
        background-color: #e8f5e9;
    }

    .tbl-30 textarea {
        resize: vertical;
        height: 120px;
    }

    .tbl-30 input[type="radio"] {
        width: auto;
        margin: 5px 10px 5px 0;
    }

    .btn-secondary {
        padding: 12px 24px;
        font-size: 18px;
        color: #fff;
        background-color:rgb(47, 204, 52);
        border: none;
        border-radius: 6px;
        cursor: pointer;
        transition: background-color 0.3s ease;
        display: block;
        width: 100%;
        margin-top: 20px;
    }

    .btn-secondary:hover {
        background-color:rgb(44, 170, 50);
    }

    .error, .success, .warning {
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

    .warning {
        background-color: #fff3cd;
        color: #856404;
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

</style>
