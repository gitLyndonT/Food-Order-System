<?php include('partails-front/menu.php'); ?>

<!-- Categories Section Starts Here -->
<section class="categories">
    <div class="container">
        <h2 class="text-center">Explore Foods</h2>

        <?php
            // SQL query to display only active and featured categories
            $sql = "SELECT * FROM tbl_category WHERE active='Yes' AND featured='Yes'";

            // Execute the query
            $res = mysqli_query($conn, $sql);

            // Debugging: print the query to check the result
            if (!$res) {
                die("Query Failed: " . mysqli_error($conn)); // Error handling
            }

            // Count rows
            $count = mysqli_num_rows($res);

            if($count > 0)
            {
                // Categories available
                while($row = mysqli_fetch_assoc($res))
                {
                    // Get the values
                    $id = $row['id'];
                    $title = $row['title'];
                    $image_name = $row['image_name'];
                    ?>

                    <a href="<?php echo SITEURL; ?>category-foods.php?category_id=<?php echo $id; ?>">
                        <div class="box-3 float-container">

                            <?php
                                if($image_name == "")
                                {
                                    // Image not available
                                    echo "<div class='error'>Image Not Found.</div>";
                                }
                                else
                                {
                                    // Image available
                                    ?>
                                    <img src="<?php echo SITEURL; ?>images/category/<?php echo $image_name; ?>" alt="<?php echo $title; ?>" class="img-responsive img-curve category-img">
                                    <?php
                                }
                            ?>

                            <h3 class="float-text text-white"><?php echo $title; ?></h3>
                        </div>
                    </a>

                    <?php
                }
            }
            else
            {
                // Categories not available or matching the criteria
                echo "<div class='error'>No Featured or Active Categories Found.</div>";
            }
        ?>

        <div class="clearfix"></div>
    </div>
</section>
<!-- Categories Section Ends Here -->

<?php include('partails-front/footer.php'); ?>

<style>
    .categories .box-3 {
        width: 30%;
        margin: 1.5rem;
        border-radius: 10px;
        overflow: hidden;
        position: relative;
        text-align: center;
    }

    .categories .box-3 img.category-img {
        width: 100%;
        height: 200px;
        object-fit: cover; /* Ensures images have a uniform size and aspect ratio */
        border-radius: 8px;
    }

    .categories .box-3 h3 {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        font-size: 1.5rem;
        font-weight: bold;
        color: white;
        text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.5);
    }

    .categories .clearfix {
        clear: both;
    }

    .categories a {
        text-decoration: none;
    }
</style>
