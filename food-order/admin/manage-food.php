<?php include('partails/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Manage Food</h1>

        <br /><br />

        <!-- Button to Add Food -->
        <a href="<?php echo SITEURL; ?>admin/add-food.php" class="btn-primary">Add Foods</a>

        <br /><br /><br />

        <?php
            if(isset($_SESSION['add'])) 
            {
                echo $_SESSION['add'];
                unset($_SESSION['add']);
            }

            if(isset($_SESSION['delete'])) 
            {
                echo $_SESSION['delete'];
                unset($_SESSION['delete']);
            }

            if(isset($_SESSION['upload'])) 
            {
                echo $_SESSION['upload'];
                unset($_SESSION['upload']);
            }

            if(isset($_SESSION['unauthorize'])) 
            {
                echo $_SESSION['unauthorize'];
                unset($_SESSION['unauthorize']);
            }

            if(isset($_SESSION['update'])) 
            {
                echo $_SESSION['update'];
                unset($_SESSION['update']);
            }
        ?>

        <table class="tbl-full">
            <tr>
                <th>S.N</th>
                <th>Title</th>
                <th>Price</th>
                <th>Image</th>
                <th>Featured</th>
                <th>Active</th>
                <th>Actions</th>
            </tr>

            <?php
                // Create a SQL query to get all the food
                $sql = "SELECT * FROM tbl_foods";

                // Execute the query
                $res = mysqli_query($conn, $sql);

                // Count rows
                $count = mysqli_num_rows($res);

                $sn = 1;

                if ($count > 0) {
                    // We have food in the database
                    while ($row = mysqli_fetch_assoc($res)) {
                        // Get the value from individual columns
                        $id = $row['id'];
                        $title = $row['title'];
                        $price = $row['price'];
                        $image_name = $row['image_name'];
                        $featured = $row['featured'];
                        $active = $row['active'];
                        ?>
                        <tr>
                            <td><?php echo $sn++; ?>.</td>
                            <td><?php echo $title; ?></td>

                            <!-- Fixing Price Display -->
                            <td>$<?php echo number_format(floatval($price), 2); ?></td>

                            <td>
                                <?php 
                                    // Check whether we have an image or not
                                    if ($image_name == "") {
                                        // Display error message
                                        echo "<div class='error'>Image Not Added.</div>";
                                    } else {
                                        // We have an image, display it
                                        ?>
                                        <img src="<?php echo SITEURL; ?>images/food/<?php echo $image_name; ?>" width="100px">
                                        <?php
                                    }
                                ?>
                            </td>
                            <td><?php echo $featured; ?></td>
                            <td><?php echo $active; ?></td>
                            <td>
                                <a href="<?php echo SITEURL; ?>admin/update-food.php?id=<?php echo $id; ?>" class="btn-secondary">Update Food</a>
                                <a href="<?php echo SITEURL; ?>admin/delete-food.php?id=<?php echo $id; ?>&image_name=<?php echo $image_name; ?>" class="btn-danger">Delete Food</a>
                            </td>
                        </tr>
                        <?php
                    }
                } else {
                    // Food not added in the database
                    echo "<tr> <td colspan='7' class='error'> Food not Added Yet. </td></tr>";
                }
            ?>
        </table>
    </div>
</div>

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

    .tbl-full img {
        border-radius: 5px;
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
