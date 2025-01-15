<?php include('partails-front/menu.php'); ?>

<!-- fOOD sEARCH Section Starts Here -->
<section class="food-search text-center">
    <div class="container">
        <form action="<?php echo SITEURL; ?>food-search.php" method="POST">
            <input type="search" name="search" placeholder="Search for Food.." required>
            <input type="submit" name="submit" value="Search" class="btn btn-primary">
        </form>
    </div>
</section>
<!-- fOOD sEARCH Section Ends Here -->

<!-- fOOD Menu Section Starts Here -->
<section class="food-menu">
    <div class="container">
        <h2 class="text-center">Food Menu</h2>

        <?php
        // Fetch all active food items
        $sql = "SELECT * FROM tbl_foods WHERE active='Yes'";
        $res = mysqli_query($conn, $sql);

        if(mysqli_num_rows($res) > 0) {
            $count = 0;
            while($row = mysqli_fetch_assoc($res)) {
                // Open a new row for every 3 items
                if ($count % 3 == 0) {
                    echo '<div class="row mb-4">';
                }

                $id = $row['id'];
                $title = $row['title'];
                $description = $row['description'];
                $price = $row['price'];
                $image_name = $row['image_name'];
                ?>

                <!-- Food item box -->
                <div class="col-lg-4 col-md-6 col-sm-12 food-menu-box">
                    <div class="food-menu-img">
                        <?php
                        if($image_name == "") {
                            echo "<div class='error'>Image Not Available.</div>";
                        } else {
                            ?>
                            <img src="<?php echo SITEURL; ?>images/food/<?php echo $image_name; ?>" alt="<?php echo $title; ?>" class="img-responsive img-curve">
                            <?php
                        }
                        ?>
                    </div>

                    <div class="food-menu-desc">
                        <h4><?php echo $title; ?></h4>
                        <p class="food-price">$<?php echo $price; ?></p>
                        <div class="food-detail">
                            <p><?php echo $description; ?></p>
                        </div>
                        <a href="<?php echo SITEURL; ?>order.php?food_id=<?php echo $id; ?>" class="btn btn-primary">Order Now</a>
                    </div>
                </div>

                <?php
                $count++;

                // Close the row after every 3 items
                if ($count % 3 == 0) {
                    echo '</div>';
                }
            }

            // Close the last row if it has less than 3 items
            if ($count % 3 != 0) {
                echo '</div>';
            }
        } else {
            echo "<div class='error'>Food Not Found.</div>";
        }
        ?>

        <div class="clearfix"></div>
    </div>
</section>
<!-- fOOD Menu Section Ends Here -->

<?php include('partails-front/footer.php'); ?>

<style>
    .food-search {
        margin: 50px 0;
        background-color: #f9f9f9;
        padding: 40px;
        border-radius: 8px;
    }

    .food-search .btn {
        background-color: #ff5722;
        color: white;
        padding: 12px 20px;
        border-radius: 30px;
        font-size: 16px;
    }

    .food-search .btn:hover {
        background-color: #e64a19;
    }

    .food-menu {
        margin-top: 30px;
    }

    .food-menu-box {
        margin-bottom: 20px;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        background-color: #fff;
        text-align: center;
        transition: transform 0.3s ease;
    }

    .food-menu-box:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 12px rgba(0, 0, 0, 0.2);
    }

    .food-menu-img {
        height: 200px;
        margin-bottom: 15px;
        overflow: hidden;
        border-radius: 10px;
    }

    .food-menu-img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .food-menu-desc h4 {
        font-size: 22px;
        color: #333;
        margin-bottom: 10px;
    }

    .food-price {
        font-size: 18px;
        font-weight: bold;
        color: #ff5722;
        margin-bottom: 10px;
    }

    .food-detail p {
        font-size: 14px;
        color: #555;
        margin-bottom: 15px;
        text-align: justify;
        height: 80px;
        overflow-y: auto;
    }

    .btn-primary {
        background-color: #ff5722;
        color: white;
        padding: 10px 25px;
        border-radius: 30px;
        font-size: 14px;
        transition: background-color 0.3s ease;
    }

    .btn-primary:hover {
        background-color: #e64a19;
    }

    .error {
        color: red;
        font-weight: bold;
        padding: 10px;
        background-color: #f2dede;
        border-radius: 5px;
        text-align: center;
    }

    .clearfix {
        clear: both;
    }

    @media (max-width: 768px) {
        .food-menu-box {
            margin-bottom: 30px;
        }

        .food-menu-desc h4 {
            font-size: 20px;
        }

        .food-price {
            font-size: 16px;
        }

        .btn-primary {
            font-size: 12px;
        }
    }
</style>
