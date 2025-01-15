<?php include('partails/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Manage Order</h1>

        <br /><br /><br />

        <?php
            if(isset($_SESSION['update'])) 
            {
                echo $_SESSION['update'];
                unset($_SESSION['update']);
            }
        ?>
        <br><br>

        <table class="tbl-full">
            <tr>
                <th>S.N</th>
                <th>Food</th>
                <th>Price</th>
                <th>Qty.</th>
                <th>Total</th>
                <th>Order Date</th>
                <th>Status</th>
                <th>Customer Name</th>
                <th>Contact</th>
                <th>Email</th>
                <th>Address</th>
                <th>Actions</th>
            </tr>

            <?php
                //get all the orders from database
                $sql = "SELECT * FROM tbl_order ORDER BY id DESC"; //display a last order at first
                
                //execute
                $res = mysqli_query($conn, $sql);

                //count rows
                $count = mysqli_num_rows($res);

                $sn = 1; //serail number and set its initail value as 1

                if($count>0)
                {
                    //order avail
                    while($row = mysqli_fetch_assoc($res))
                    {
                        //get all the order details
                        $id = $row['id'];
                        $food = $row['food'];
                        $price = $row['price'];
                        $qty = $row['qty'];
                        $total = $row['total'];
                        $order_date = $row['order_date'];
                        $status = $row['status'];
                        $customer_name = $row['customer_name'];
                        $customer_contact = $row['customer_contact'];
                        $customer_email = $row['customer_email'];
                        $customer_address = $row['customer_address'];

                        ?>
                            <tr>
                                <td><?php echo $sn++; ?>. </td>
                                <td><?php echo $food; ?></td>
                                <td><?php echo $price; ?></td>
                                <td><?php echo $qty; ?></td>
                                <td><?php echo $total; ?></td>
                                <td><?php echo $order_date; ?></td>

                                <td>
                                    <?php
                                        // Status labels with fixed size
                                        if($status=="Ordered")
                                        {
                                            echo "<label class='status-ordered'>$status</label>";
                                        }
                                        else if($status=="On Delivery")
                                        {
                                            echo "<label class='status-delivery'>$status</label>";
                                        }
                                        else if($status=="Delivered")
                                        {
                                            echo "<label class='status-delivered'>$status</label>";
                                        }
                                        else if($status=="Cancelled")
                                        {
                                            echo "<label class='status-cancelled'>$status</label>";
                                        }
                                    ?>
                                </td>

                                <td><?php echo $customer_name; ?></td>
                                <td><?php echo $customer_contact; ?></td>
                                <td><?php echo $customer_email; ?></td>
                                <td><?php echo $customer_address; ?></td>
                                <td>
                                    <!-- Ensuring button size consistency -->
                                    <a href="<?php echo SITEURL; ?>admin/update-order.php?id=<?php echo $id; ?>" class="btn-update-order">Update Order</a>
                                </td>
                            </tr>

                        <?php
                    }
                }
                else
                {
                    //order not avail
                    echo "<tr><td colspan='12' class='error'>Orders Not Available.</td></tr>";
                }
            ?>

        </table>
    </div>
</div>

<?php include('partails/footer.php'); ?>

<style>
    /* Ensure all status labels are the same size */
    .tbl-full label {
        font-weight: bold;
        padding: 6px 12px;
        border-radius: 5px;
        color: #fff;
        display: inline-block;
        text-align: center;
        width: 120px; /* Fixed width for uniform size */
        text-overflow: ellipsis;
        overflow: hidden;
        white-space: nowrap;
    }

    /* Status colors */
    .status-ordered {
        background-color: #ff9800; /* Orange */
    }

    .status-delivery {
        background-color: #ff5722; /* Red */
    }

    .status-delivered {
        background-color: #4caf50; /* Green */
    }

    .status-cancelled {
        background-color: #f44336; /* Dark Red */
    }

    /* Table styling */
    .tbl-full {
        width: 100%;
        border-collapse: collapse;
    }

    .tbl-full th, .tbl-full td {
        padding: 15px;
        text-align: center;
        border: 1px solid #ddd;
    }

    .tbl-full th {
        background-color: #f2f2f2;
    }

    .error {
        color: red;
        font-weight: bold;
    }

    /* Styling for Update Order button */
    .btn-update-order {
        padding: 8px 16px;
        background-color: #007bff;
        color: white;
        text-decoration: none;
        border-radius: 5px;
        display: inline-block;
        text-align: center;
        width: 150px; /* Fixed width for button */
        box-sizing: border-box;
    }

    .btn-update-order:hover {
        background-color: #0056b3;
    }

    /* Optional: You can also add consistency for other buttons here */
</style>
