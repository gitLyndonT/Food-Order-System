<?php include('partails/menu.php'); ?>

<!-- Main Content Section Starts -->
<div class="main-content">
    <div class="wrapper">
        <h1>Dashboard</h1>
        <br><br>
        <?php 
            if(isset($_SESSION['login'])) {
                echo $_SESSION['login'];
                unset($_SESSION['login']);
            }
        ?>
        <br><br>

        <div class="dashboard-stats">

            <div class="stat-box">
                <?php
                    //sql query
                    $sql = "SELECT * FROM tbl_category";
                    //execute query
                    $res = mysqli_query($conn, $sql);
                    //count rows
                    $count = mysqli_num_rows($res);
                ?>
                <div class="icon">
                    <i class="fa fa-th-large"></i> <!-- Categories Icon -->
                </div>
                <h1><?php echo $count; ?></h1>
                <p>Categories</p>
            </div>

            <div class="stat-box">
                <?php
                    //sql query
                    $sql2 = "SELECT * FROM tbl_foods";
                    //execute query
                    $res2 = mysqli_query($conn, $sql2);
                    //count rows
                    $count2 = mysqli_num_rows($res2);
                ?>
                <div class="icon">
                    <i class="fa fa-pizza-slice"></i> <!-- Changed to pizza slice for Foods -->
                </div>
                <h1><?php echo $count2; ?></h1>
                <p>Foods</p>
            </div>

            <div class="stat-box">
                <?php
                    //sql query
                    $sql3 = "SELECT * FROM tbl_order";
                    //execute query
                    $res3 = mysqli_query($conn, $sql3);
                    //count rows
                    $count3 = mysqli_num_rows($res3);
                ?>
                <div class="icon">
                    <i class="fa fa-list-alt"></i>
                </div>
                <h1><?php echo $count3; ?></h1>
                <p>Total Orders</p>
            </div>

            <div class="stat-box">
                <?php
                    //create sql query to get total revenue generated
                    $sql4 = "SELECT SUM(total) AS Total FROM tbl_order WHERE status='Delivered'";
                    //execute
                    $res4 = mysqli_query($conn, $sql4);
                    //get the value
                    $row4 = mysqli_fetch_assoc($res4);
                    //get the total revenue
                    $total_revenue = $row4['Total'];
                ?>
                <div class="icon">
                    <i class="fa fa-dollar-sign"></i>
                </div>
                <h1>$<?php echo $total_revenue; ?></h1>
                <p>Revenue Generated</p>
            </div>

        </div>

        <div class="clearfix"></div>

    </div>
</div>
<!-- Main Content Section Ends -->

<?php include('partails/footer.php'); ?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<style>
    .dashboard-stats {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
        margin-top: 30px;
    }

    .stat-box {
        background: linear-gradient(145deg, #f1f1f1, #ffffff);
        border-radius: 15px;
        padding: 30px;
        text-align: center;
        box-shadow: 0 4px 10px rgb(240, 235, 235);
        transition: all 0.3s ease-in-out;
    }

    .stat-box h1 {
        font-size: 48px;
        color: white;
        margin: 0;
        font-weight: bold;
        text-transform: uppercase;
    }

    .stat-box p {
        font-size: 18px;
        color: white;
        margin-top: 15px;
        text-transform: capitalize;
    }

    .stat-box:hover {
        background: linear-gradient(145deg, #f0f0f0, #e1e1e1);
        transform: translateY(-10px);
        box-shadow: 0 8px 15px rgba(0, 0, 0, 0.15);
        cursor: pointer;
    }

    .stat-box:active {
        transform: translateY(-5px);
    }

    .stat-box:nth-child(1) {
        background: #ff6b81;
        color: white;
    }

    .stat-box:nth-child(2) {
        background: #ff6b81;
        color: white;
    }

    .stat-box:nth-child(3) {
        background: #ff6b81;
        color: white;
    }

    .stat-box:nth-child(4) {
        background: #ff6b81;
        color: white;
    }

    .icon {
        font-size: 50px;
        margin-bottom: 15px;
    }

    .stat-box h1 {
        font-size: 2rem;
    }

    .clearfix {
        clear: both;
    }

    @media (max-width: 768px) {
        .dashboard-stats {
            grid-template-columns: 1fr;
        }
    }
</style>
