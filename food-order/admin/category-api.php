<?php
session_start();
// Include the database connection
include('../config/constants.php');

// Set the content type to JSON
header('Content-Type: application/json');

// Start the session to use session variables

// Check if the form was submitted (ensure you're receiving data from the form)
if (isset($_POST['title'])) {
    // Get form data
    $title = $_POST['title'];
    $featured = $_POST['featured'];
    $active = $_POST['active'];

    // Handle image upload (if an image is selected)
    if (isset($_FILES['image']['name']) && $_FILES['image']['name'] != "") {
        // Upload the image logic here
        // (e.g., move the uploaded file to your desired folder)
        $image_name = $_FILES['image']['name'];
        $image_tmp = $_FILES['image']['tmp_name'];
        $upload_path = "../images/category/" . $image_name;
        move_uploaded_file($image_tmp, $upload_path);
    } else {
        // If no image is selected, set a default or null value
        $image_name = "";
    }

    // Insert the category into the database
    $sql = "INSERT INTO tbl_category (title, image_name, featured, active) 
            VALUES ('$title', '$image_name', '$featured', '$active')";

    // Execute query
    $result = mysqli_query($conn, $sql);

    // Check if the category was added successfully
    if ($result) {
        // Category added successfully
        $_SESSION['add'] = "<div class='success'>Category added successfully.</div>";
        echo json_encode(['message' => 'Category added successfully']);
    } else {
        // Error adding category
        $_SESSION['add'] = "<div class='error'>Failed to add category.</div>";
        echo json_encode(['message' => 'Failed to add category']);
    }
} else {
    // If data is not received from the form
    echo json_encode(['message' => 'Invalid request']);
}
?>

?>
