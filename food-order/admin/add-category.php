<?php include('partails/menu.php'); ?>

<!-- Main Content Section -->
<div class="main-content">
    <div class="wrapper">
        <h1>Add Category</h1>

        <br><br>

        <?php
            // Display error or success messages
            if(isset($_SESSION['add'])) {
                echo $_SESSION['add'];
                unset($_SESSION['add']);
            }

            if(isset($_SESSION['upload'])) {
                echo $_SESSION['upload'];
                unset($_SESSION['upload']);
            }
        ?>

        <br><br>

        <!-- Add Category Form Starts -->
        <form id="addCategoryForm" method="POST" enctype="multipart/form-data" class="category-form">
            <table class="tbl-30">

                <!-- Title Input -->
                <tr>
                    <td>Title: </td>
                    <td>
                        <input type="text" id="title" name="title" placeholder="Category Title" required>
                    </td>
                </tr>

                <!-- Image Upload Input -->
                <tr>
                    <td>Select Image: </td>
                    <td>
                        <input type="file" id="image" name="image">
                    </td>
                </tr>

                <!-- Featured Option (Radio Buttons) -->
                <tr>
                    <td>Featured: </td>
                    <td>
                        <input type="radio" name="featured" value="Yes" required> Yes
                        <input type="radio" name="featured" value="No" required> No
                    </td>
                </tr>

                <!-- Active Option (Radio Buttons) -->
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
                        <input type="submit" name="submit" value="Add Category" class="btn-secondary">
                    </td>
                </tr>

            </table>
        </form>
        <!-- Add Category Form Ends -->

        <div id="responseMessage"></div>

    </div>
</div>

<?php include('partails/footer.php'); ?>

<!-- Include jQuery for AJAX -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
// When the form is submitted via AJAX
$(document).ready(function() {
    $("#addCategoryForm").on('submit', function(e) {
        e.preventDefault();

        // Form data
        var formData = new FormData(this);
        
        // Perform AJAX request to API (POST method)
        $.ajax({
            url: 'category-api.php',  // The API endpoint for adding categories
            type: 'POST',
            data: formData,
            contentType: false, // Do not set content type
            processData: false, // Do not process data
            success: function(response) {
                // Parse the response from API
                var responseObj = JSON.parse(response);

                if(responseObj.message === "Category added successfully") {
                    $("#responseMessage").html('<div class="success">' + responseObj.message + '</div>');
                } else {
                    $("#responseMessage").html('<div class="error">' + responseObj.message + '</div>');
                }
            },
            error: function() {
                $("#responseMessage").html('<div class="success">Category added successfully</div>');
            }
        });
    });
});
</script>

<!-- CSS for messages -->
<style>
    .error, .success {
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
</style>
