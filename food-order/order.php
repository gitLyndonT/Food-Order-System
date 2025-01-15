<?php 
    // Start the session at the beginning of the page
    session_start(); 
    
    include('partails-front/menu.php'); 

    // Ensure SITEURL is correctly defined
    if (!defined('SITEURL')) {
        define('SITEURL', 'http://localhost/yourproject/');  // Replace with your actual URL
    }

    // Check and display session message if set
    if(isset($_SESSION['order'])) {
        echo $_SESSION['order'];
        // Clear the session message after displaying it
        unset($_SESSION['order']);
    }

    // Check whether food id is set or not
    if(isset($_GET['food_id'])) {
        // Get the food id and details of selected food
        $food_id = $_GET['food_id'];

        // Get the details of selected food
        $sql = "SELECT * FROM tbl_foods WHERE id=$food_id";
        $res = mysqli_query($conn, $sql);

        // Count rows
        $count = mysqli_num_rows($res);

        if($count == 1) {
            // We have data, get the data from database
            $row = mysqli_fetch_assoc($res);

            $title = $row['title'];
            $price = $row['price'];
            $image_name = $row['image_name'];
        } else {
            // Food not available
            header('Location: '.SITEURL);
            exit(); // Make sure the script stops execution after the redirect
        }
    } else {
        // Redirect to homepage if no food_id is set
        header('Location: '.SITEURL);
        exit(); // Make sure the script stops execution after the redirect
    }
?>

<!-- fOOD sEARCH Section Starts Here -->
<section class="food-search">
    <div class="container">
        <h2 class="text-center text-white">Fill this form to confirm your order.</h2>

        <form action="" method="POST" class="order">
            <fieldset>
                <legend>Selected Food</legend>

                <div class="food-menu-img">
                    <?php
                        // Check whether the image is available or not
                        if($image_name == "") {
                            // Image not available
                            echo "<div class='error'>Image Not Available.</div>";
                        } else {
                            ?>
                                <img src="<?php echo SITEURL; ?>images/food/<?php echo $image_name; ?>" alt="Food Image" class="img-responsive img-curve">
                            <?php
                        }
                    ?>
                </div>

                <div class="food-menu-desc">
                    <h3><?php echo $title; ?></h3>
                    <input type="hidden" name="food" value="<?php echo $title ?>">
                    
                    <p class="food-price">$<?php echo $price; ?></p>
                    <input type="hidden" name="price" value="<?php echo $price ?>">

                    <div class="order-label">Quantity</div>
                    <input type="number" name="qty" class="input-responsive" value="1" required>
                </div>
            </fieldset>
            
            <fieldset>
                <legend>Delivery Details</legend>
                <div class="order-label">Full Name</div>
                <input type="text" name="full-name" placeholder="E.g. Lyndon Tamarion" class="input-responsive" required>

                <div class="order-label">Phone Number</div>
                <input type="tel" name="contact" placeholder="E.g. 9843xxxxxx" class="input-responsive" required>

                <div class="order-label">Email</div>
                <input type="email" name="email" placeholder="E.g. hi@lyndontamarion.com" class="input-responsive" required>

                <div class="order-label">Address</div>
                <textarea name="address" rows="10" placeholder="E.g. Street, City, Country" class="input-responsive" required></textarea>

                <input type="submit" name="submit" value="Confirm Order" class="btn btn-primary">
            </fieldset>
        </form>

        <?php
            // Check whether submit button is clicked or not
            if(isset($_POST['submit'])) {
                // Get all the details from the form
                $food = $_POST['food'];
                $price = $_POST['price'];
                $qty = $_POST['qty'];

                $total = $price * $qty; // Total = price x qty
                $order_date = date("Y-m-d h:i:sa"); // Order date
                $status = "Ordered"; // Ordered, on delivery, delivered, cancelled

                $customer_name = $_POST['full-name'];
                $customer_contact = $_POST['contact'];
                $customer_email = $_POST['email'];
                $customer_address = $_POST['address'];

                // Save the order in database
                $sql2 = "INSERT INTO tbl_order SET
                    food = '$food',
                    price = $price,
                    qty = $qty,
                    total = $total,
                    order_date = '$order_date',
                    status = '$status',
                    customer_name = '$customer_name',
                    customer_contact = '$customer_contact',
                    customer_email = '$customer_email',
                    customer_address = '$customer_address'";

                // Execute the query
                $res2 = mysqli_query($conn, $sql2);

                // Check whether query executed successfully or not
                if($res2 == TRUE) 
                {
                    // Query executed and order saved
                    $_SESSION['order'] = "<div class='success text-center'>Food Ordered Successfully.</div>";
                    header('Location: '.SITEURL); // Redirect to homepage
                } 
                else 
                {
                    // Failed to save order
                    $_SESSION['order'] = "<div class='error text-center'>Failed to Order Food.</div>";
                    header('Location: '.SITEURL); // Redirect to homepage
                }
            }
        ?>
    </div>
</section>
<!-- fOOD sEARCH Section Ends Here -->

<?php include('partails-front/footer.php'); ?>
