<?php include('partails/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update Category</h1>

        <br><br>

        <?php
        
            if(isset($_GET['id']))
            {
                // Get the id and other details
                $id = $_GET['id'];
                $sql = "SELECT * FROM tbl_category WHERE id=$id";

                // Execute the query
                $res = mysqli_query($conn, $sql);

                // Assign the number of rows in the result to $count
                $count = mysqli_num_rows($res);

                if($count == 1)
                {
                    // Get the data if the category is found
                    $row = mysqli_fetch_assoc($res);
                    // Retrieve data like title, image_name, etc.
                    $title = $row['title'];
                    $current_image = isset($row['image_name']) ? $row['image_name'] : ''; // Check if 'image_name' exists
                    $featured = $row['featured'];
                    $active = $row['active'];
                }
                else
                {
                    // Redirect to manage category page if category is not found
                    $_SESSION['no-category-found'] = "<div class='error'>Category Not Found.</div>";
                    header('location:'.SITEURL.'admin/manage-category.php');
                    exit;
                }
            }
            else
            {
                // Redirect to manage category page if id is not set
                header('location:'.SITEURL.'admin/manage-category.php');
                exit; // Always use exit after header redirection
            }

        ?>

        <form action="" method="POST" enctype="multipart/form-data" class="category-form">

            <table class="tbl-30">
                <tr>
                    <td>Title:</td>
                    <td>
                        <input type="text" name="title" value="<?php echo $title; ?>" class="input-field">
                    </td>
                </tr>

                <tr>
                    <td>Current Image:</td>
                    <td>
                        <?php
                            if($current_image != "") 
                            {
                                // Display current image
                                ?>
                                    <img src="<?php echo SITEURL; ?>images/category/<?php echo $current_image; ?>" width="150px" class="current-image">
                                <?php
                            } else {
                                echo "<div class='error'>Image not Added.</div>";
                            }
                        ?>
                    </td>
                </tr>

                <tr>
                    <td>New Image:</td>
                    <td>
                        <input type="file" name="image" class="input-field">
                    </td>
                </tr>

                <tr>
                    <td>Featured:</td>
                    <td>
                        <input type="radio" name="featured" value="Yes" <?php if($featured == "Yes") { echo "checked"; } ?>> Yes
                        <input type="radio" name="featured" value="No" <?php if($featured == "No") { echo "checked"; } ?>> No
                    </td>
                </tr>

                <tr>
                    <td>Active:</td>
                    <td>
                        <input type="radio" name="active" value="Yes" <?php if($active == "Yes") { echo "checked"; } ?>> Yes
                        <input type="radio" name="active" value="No" <?php if($active == "No") { echo "checked"; } ?>> No
                    </td>
                </tr>

                <tr>
                    <td>
                        <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="submit" name="submit" value="Update Category" class="btn-secondary">
                    </td>
                </tr>

            </table>
        </form>
         
        <?php
        
            if(isset($_POST['submit']))
            {
                //get all the values from our form
                $id = $_POST['id'];
                $title = $_POST['title'];
                $current_image = $_POST['current_image'];
                $featured = $_POST['featured'];
                $active = $_POST['active'];

                // updating new image
                if(isset($_FILES['image']['name']))
                {
                    // get the dateils
                    $image_name = $_FILES['image']['name'];

                    if($image_name != "")
                    {
                        //image avail
                         // Auto-rename the image
                         $ext = pathinfo($image_name, PATHINFO_EXTENSION);
                         $image_name = "Food_Category_".rand(000, 999).'.'.$ext;
 
                         // Set the target directory for images
                         $target_dir = "../images/category/";
 
                         // Check if the directory exists, create if not
                         if (!is_dir($target_dir)) {
                             mkdir($target_dir, 0777, true);
                         }
 
                         $source_path = $_FILES['image']['tmp_name'];
                         $destination_path = $target_dir . $image_name;
 
                         // Upload the image
                         $upload = move_uploaded_file($source_path, $destination_path);
 
                         if($upload == false) 
                         {
                             $_SESSION['upload'] = "<div class='error'>Failed to Upload Image.</div>";
                             header('location:'.SITEURL.'admin/manage-category.php');
                             die();
                         }
                         //remove current image
                         if($current_image !="")
                         {
                            $remove_path = "../images/category/".$current_image;
                            $remove = unlink($remove_path);

                            //check whether the image is remove or not
                            if($remove==FALSE)
                            {
                                $_SESSION['failed-remove'] = "<div class='error'>Failed to remove current Image.</div>";
                                header('location:'.SITEURL.'admin/manage-category.php');
                                die();
                            }
                         }    
                    }
                    else
                    {
                        $image_name = $current_image;
                    }
                }
                else
                {
                    $image_name = $current_image;
                }

                //update the databsae
                $sql2 = "UPDATE tbl_category SET
                    title = '$title',
                    image_name = '$image_name',
                    featured = '$featured',
                    active = '$active'
                    WHERE id=$id
                ";

                //execute the query
                $res2 = mysqli_query($conn, $sql2);

                if($res2==TRUE)
                {
                    //category updated
                    $_SESSION['update'] = "<div class='success'>Category Updated Successfully.</div>";
                    header('location:'.SITEURL.'admin/manage-category.php');
                }
                else
                {
                    //failed to update
                    $_SESSION['update'] = "<div class='error'>Failed to Update Category.</div>";
                    header('location:'.SITEURL.'admin/manage-category.php');
                }
            }
        
        ?>

    </div>
</div>

<?php include('partails/footer.php'); ?>

<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        margin: 0;
        padding: 0;
    }

    .main-content {
        background-color: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        max-width: 900px;
        margin: 50px auto;
    }

    
