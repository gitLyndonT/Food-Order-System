<?php
// Make sure no output is sent before this point
ob_start();  // Start output buffering at the top of the file

include('partails/menu.php'); 

// Check whether id is set or not
if (isset($_GET['id'])) {
    // Get all the details
    $id = $_GET['id'];

    $sql2 = "SELECT * FROM tbl_foods WHERE id=$id";
    // Execute
    $res2 = mysqli_query($conn, $sql2);
    
    $row2 = mysqli_fetch_assoc($res2);

    // Get the value based on the selection
    $title = $row2['title'];
    $description = $row2['description'];
    $price = $row2['price'];
    $current_image = $row2['image_name'];
    $current_category = $row2['category_id'];
    $featured = $row2['featured'];
    $active = $row2['active'];
} else {
    // Redirect to the manage food before any output
    header('location:' . SITEURL . 'admin/manage-food.php');
    exit(); // Always call exit after header to stop further script execution
}
?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update Food</h1>

        <form action="" method="POST" enctype="multipart/form-data">
            <div class="form-container">
                <div class="form-group">
                    <label for="title">Title: </label>
                    <input type="text" name="title" id="title" value="<?php echo $title; ?>" class="input-field">
                </div>

                <div class="form-group">
                    <label for="description">Description: </label>
                    <textarea name="description" id="description" cols="30" rows="5" class="input-field"><?php echo $description; ?></textarea>
                </div>

                <div class="form-group">
                    <label for="price">Price: </label>
                    <input type="number" name="price" id="price" value="<?php echo $price; ?>" class="input-field">
                </div>

                <div class="form-group">
                    <label>Current Image: </label>
                    <div class="current-image">
                        <?php
                            if ($current_image == "") 
                            {
                                echo "<div class='error'>Image Not Available.</div>";
                            } 
                            else 
                            {
                                ?>
                                <img src="<?php echo SITEURL; ?>images/food/<?php echo $current_image; ?>" width="150px">
                                <?php
                            }
                        ?>
                    </div>
                </div>

                <div class="form-group">
                    <label for="image">Select New Image: </label>
                    <input type="file" name="image" id="image" class="input-field">
                </div>

                <div class="form-group">
                    <label for="category">Category: </label>
                    <select name="category" id="category" class="input-field">
                        <?php 
                            // Query to get active categories
                            $sql = "SELECT * FROM tbl_category WHERE active='Yes'";

                            // Execute
                            $res = mysqli_query($conn, $sql);

                            // Check if categories exist
                            $count = mysqli_num_rows($res);

                            // Check whether category is available or not
                            if ($count > 0) 
                            {
                                while ($row = mysqli_fetch_assoc($res)) 
                                {
                                    $category_title = $row['title'];
                                    $category_id = $row['id'];

                                    ?>
                                        <option <?php if ($current_category == $category_id) { echo "selected"; } ?> value="<?php echo $category_id; ?>"><?php echo $category_title; ?></option>
                                    <?php
                                }
                            } 
                            else 
                            {
                                echo "<option value='0'>Category Not Available.</option>";
                            }
                        ?>
                    </select>
                </div>

                <div class="form-group">
                    <label>Featured: </label>
                    <label class="radio-label"><input <?php if ($featured == "Yes") { echo "checked"; } ?> type="radio" name="featured" value="Yes"> Yes</label>
                    <label class="radio-label"><input <?php if ($featured == "No") { echo "checked"; } ?> type="radio" name="featured" value="No"> No</label>
                </div>

                <div class="form-group">
                    <label>Active: </label>
                    <label class="radio-label"><input <?php if ($active == "Yes") { echo "checked"; } ?> type="radio" name="active" value="Yes"> Yes</label>
                    <label class="radio-label"><input <?php if ($active == "No") { echo "checked"; } ?> type="radio" name="active" value="No"> No</label>
                </div>

                <div class="form-group">
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">
                    <input type="submit" name="submit" value="Update Food" class="btn-primary">
                </div>
            </div>
        </form>

        <?php
            if (isset($_POST['submit'])) 
            {
                // Get all the details from the form
                $id = $_POST['id'];
                $current_image = $_POST['current_image'];
                
                // Escape special characters to prevent SQL injection
                $title = mysqli_real_escape_string($conn, $_POST['title']);
                $description = mysqli_real_escape_string($conn, $_POST['description']);
                $price = mysqli_real_escape_string($conn, $_POST['price']);
                $category = mysqli_real_escape_string($conn, $_POST['category']);
                $featured = mysqli_real_escape_string($conn, $_POST['featured']);
                $active = mysqli_real_escape_string($conn, $_POST['active']);

                // Upload the image if selected
                if (isset($_FILES['image']['name'])) {
                    // Upload button
                    $image_name = $_FILES['image']['name'];

                    if ($image_name != "") {
                        // Rename the image
                        $ext_array = explode('.', $image_name); 
                        $ext = end($ext_array); 

                        $image_name = "Food-Name" . rand(0000, 9999) . '.' . $ext;

                        // Get the source path and destination path
                        $src_path = $_FILES['image']['tmp_name'];
                        $dest_path = "../images/food/" . $image_name;

                        // Upload image
                        $upload = move_uploaded_file($src_path, $dest_path);

                        if ($upload == FALSE) 
                        {
                            $_SESSION['upload'] = "<div class='error'>Failed to Upload New Image.</div>";
                            header('location:' . SITEURL . 'admin/manage-food.php');
                            exit(); // Always call exit after header
                        }

                        // Remove current image
                        if ($current_image != "") 
                        {
                            $remove_path = "../images/food/" . $current_image;
                            $remove = unlink($remove_path);

                            if ($remove == FALSE) {
                                $_SESSION['remove-failed'] = "<div class='error'>Failed to remove Current Image.</div>";
                                header('location:' . SITEURL . 'admin/manage-food.php');
                                exit(); // Always call exit after header
                            }
                        }
                    } else {
                        $image_name = $current_image; // Default Image when Image is not Selected
                    }
                } else {
                    $image_name = $current_image; // Default Image when Button is Not Clicked
                }

                // Update the food in the database
                $sql3 = "UPDATE tbl_foods SET
                    title = '$title',
                    description = '$description',
                    price = '$price',
                    image_name = '$image_name',
                    category_id = '$category',
                    featured = '$featured',
                    active = '$active'
                    WHERE id = $id";

                // Execute the query
                $res3 = mysqli_query($conn, $sql3);

                if ($res3 == TRUE) 
                {
                    $_SESSION['update'] = "<div class='success'>Food Updated Successfully.</div>";
                    header('location:' . SITEURL . 'admin/manage-food.php');
                    exit(); // Always call exit after header
                } 
                else 
                {
                    $_SESSION['update'] = "<div class='error'>Failed to Update Food.</div>";
                    header('location:' . SITEURL . 'admin/manage-food.php');
                    exit(); // Always call exit after header
                }
            }
        ?>

    </div>
</div>

<?php include('partails/footer.php'); ?>

<?php
    // End output buffering and flush the output
    ob_end_flush();
?>

<style>
    .input-field {
        padding: 10px;
        margin: 10px 0;
        width: 100%;
        box-sizing: border-box;
        border: 1px solid #ccc;
        border-radius: 5px;
        background-color: #f9f9f9;
    }

    .form-container {
        background-color: #fff;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        padding: 20px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        font-weight: bold;
        display: block;
        margin-bottom: 5px;
    }

    .form-group select, .form-group input[type="file"] {
        font-size: 14px;
    }

    .radio-label {
        margin-right: 20px;
    }

    .btn-primary {
        background-color: #5C9E66;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 16px;
    }

    .btn-primary:hover {
        background-color: #4C7D4F;
    }

    .current-image img {
        border: 2px solid #ddd;
        border-radius: 8px;
        padding: 5px;
    }

    .error, .success {
        padding: 10px;
        margin-top: 10px;
        border-radius: 5px;
        font-weight: bold;
        text-align: center;
    }

    .error {
        background-color: #f8d7da;
        color: #721c24;
    }

    .success {
        background-color: #d4edda;
        color: #155724;
    }

    .main-content {
        padding: 30px;
        background-color: #f4f4f4;
        border-radius: 10px;
        max-width: 1000px;
        margin: 30px auto;
    }

    h1 {
        text-align: center;
        color: #333;
        font-size: 32px;
        margin-bottom: 20px;
    }
</style>
