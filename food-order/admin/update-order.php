<?php include('partails/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update Order</h1>
        <br><br>

        <?php
        // Checking if the 'id' parameter is passed in the URL to identify which order to update
        if (isset($_GET['id'])) {
            $id = $_GET['id'];

            // SQL query to retrieve the order data from the database based on the order ID
            $sql = "SELECT * FROM tbl_order WHERE id=$id";
            $res = mysqli_query($conn, $sql);
            $count = mysqli_num_rows($res);

            // If order is found, populate variables with the order data
            if ($count == 1) {
                $row = mysqli_fetch_assoc($res);
                $food = $row['food'];
                $price = $row['price'];
                $qty = $row['qty'];
                $status = $row['status'];
                $customer_name = $row['customer_name'];
                $customer_contact = $row['customer_contact'];
                $customer_email = $row['customer_email'];
                $customer_address = $row['customer_address'];
            } else {
                // Redirect if no order is found for the given ID
                header('location:' . SITEURL . 'admin/manage-order.php');
                exit;
            }
        } else {
            // Redirect if 'id' parameter is not found in the URL
            header('location:' . SITEURL . 'admin/manage-order.php');
            exit;
        }
        ?>

        <!-- Form to update the order information -->
        <form action="" method="POST">
            <table class="form-table">
                <!-- Display current order details, such as food name and price -->
                <tr>
                    <td>Food Name:</td>
                    <td><b><?php echo $food; ?></b></td>
                </tr>

                <tr>
                    <td>Price:</td>
                    <td><b>$<?php echo $price; ?></b></td>
                </tr>

                <!-- Field to update the quantity of food items ordered -->
                <tr>
                    <td>Qty:</td>
                    <td><input type="number" name="qty" value="<?php echo $qty; ?>" class="form-input"></td>
                </tr>

                <!-- Dropdown to update the order status -->
                <tr>
                    <td>Status:</td>
                    <td>
                        <select name="status" class="form-input">
                            <option <?php if ($status == "Ordered") echo "selected"; ?> value="Ordered">Ordered</option>
                            <option <?php if ($status == "On Delivery") echo "selected"; ?> value="On Delivery">On Delivery</option>
                            <option <?php if ($status == "Delivered") echo "selected"; ?> value="Delivered">Delivered</option>
                            <option <?php if ($status == "Cancelled") echo "selected"; ?> value="Cancelled">Cancelled</option>
                        </select>
                    </td>
                </tr>

                <!-- Fields for customer details that can be updated -->
                <tr>
                    <td>Customer Name:</td>
                    <td><input type="text" name="customer_name" value="<?php echo $customer_name; ?>" class="form-input"></td>
                </tr>

                <tr>
                    <td>Customer Contact:</td>
                    <td><input type="text" name="customer_contact" value="<?php echo $customer_contact; ?>" class="form-input"></td>
                </tr>

                <tr>
                    <td>Customer Email:</td>
                    <td><input type="text" name="customer_email" value="<?php echo $customer_email; ?>" class="form-input"></td>
                </tr>

                <tr>
                    <td>Customer Address:</td>
                    <td><textarea name="customer_address" cols="30" rows="5" class="form-input"><?php echo $customer_address; ?></textarea></td>
                </tr>

                <!-- Hidden fields to preserve ID and price for the update query -->
                <tr>
                    <td colspan="2" class="text-center">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="hidden" name="price" value="<?php echo $price; ?>">
                        <input type="submit" name="submit" value="Update Order" class="btn-primary">
                    </td>
                </tr>
            </table>
        </form>

        <?php
        // Handling the form submission to update the order details
        if (isset($_POST['submit'])) {
            $id = $_POST['id'];
            $price = $_POST['price'];
            $qty = $_POST['qty'];
            $total = $price * $qty; // Calculating the total cost of the order
            $status = $_POST['status'];
            $customer_name = $_POST['customer_name'];
            $customer_contact = $_POST['customer_contact'];
            $customer_email = $_POST['customer_email'];
            $customer_address = $_POST['customer_address'];

            // SQL query to update the order data in the database
            $sql2 = "UPDATE tbl_order SET
                qty = $qty,
                total = $total,
                status = '$status',
                customer_name = '$customer_name',
                customer_contact = '$customer_contact',
                customer_email = '$customer_email',
                customer_address = '$customer_address'
                WHERE id=$id";

            $res2 = mysqli_query($conn, $sql2);

            // Check if the update was successful and redirect accordingly
            if ($res2 == TRUE) {
                $_SESSION['update'] = "<div class='success'>Order Updated Successfully.</div>";
                header('location:' . SITEURL . 'admin/manage-order.php');
            } else {
                $_SESSION['update'] = "<div class='error'>Failed to Update Order.</div>";
                header('location:' . SITEURL . 'admin/manage-order.php');
            }
        }
        ?>
    </div>
</div>

<?php include('partails/footer.php'); ?>

<style>
    body {
        font-family: 'Arial', sans-serif;
        background-color: #f4f4f9;
        margin: 0;
        padding: 0;
        color: #333;
    }

    .wrapper {
        max-width: 900px;
        margin: 40px auto;
        background: #fff;
        padding: 20px 30px;
        border-radius: 8px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    h1 {
        text-align: center;
        font-size: 28px;
        color: #444;
        margin-bottom: 20px;
    }

    .form-table {
        width: 100%;
        margin-top: 20px;
    }

    td {
        padding: 10px 0;
    }

    .form-input {
        width: 100%;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 5px;
        background-color: #f9f9f9;
        font-size: 16px;
    }

    .form-input:focus {
        border-color: #007bff;
        outline: none;
    }

    .btn-primary {
        background: #007bff;
        color: white;
        border: none;
        padding: 12px 20px;
        font-size: 16px;
        font-weight: bold;
        border-radius: 5px;
        cursor: pointer;
        text-align: center;
    }

    .btn-primary:hover {
        background: #0056b3;
    }

    .text-center {
        text-align: center;
    }

    .success, .error {
        margin-top: 10px;
        padding: 10px;
        border-radius: 5px;
        text-align: center;
    }

    .success {
        background: #d4edda;
        color: #155724;
    }

    .error {
        background: #f8d7da;
        color: #721c24;
    }
</style>
