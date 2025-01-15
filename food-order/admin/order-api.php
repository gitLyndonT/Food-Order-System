<?php
// Include database connection
include('../config/constants.php');

header('Content-Type: application/json');

// Get the HTTP request method (GET, PUT)
$method = $_SERVER['REQUEST_METHOD'];

// Function to handle the API response
function apiResponse($status, $message, $data = null) {
    echo json_encode(['status' => $status, 'message' => $message, 'data' => $data]);
    exit;
}

// Handle GET request - Fetch all orders
if ($method == 'GET') {
    $sql = "SELECT * FROM tbl_order ORDER BY id DESC"; // Fetch orders in descending order
    $res = mysqli_query($conn, $sql);

    if ($res) {
        $orders = mysqli_fetch_all($res, MYSQLI_ASSOC);
        apiResponse('success', 'Orders fetched successfully.', $orders);
    } else {
        apiResponse('error', 'Failed to fetch orders.');
    }
}

// Handle PUT request - Update an existing order's status
if ($method == 'PUT') {
    $data = json_decode(file_get_contents('php://input'), true);
    
    if (!isset($data['id'], $data['status'])) {
        apiResponse('error', 'Missing required fields.');
    }

    $id = $data['id'];
    $status = $data['status'];

    // Ensure the status is one of the valid statuses
    $validStatuses = ['Ordered', 'On Delivery', 'Delivered', 'Cancelled'];
    if (!in_array($status, $validStatuses)) {
        apiResponse('error', 'Invalid status.');
    }

    // Update the order status
    $updateQuery = "UPDATE tbl_order SET status = '$status' WHERE id = '$id'";
    $updateRes = mysqli_query($conn, $updateQuery);

    if ($updateRes) {
        apiResponse('success', 'Order status updated successfully.');
    } else {
        apiResponse('error', 'Failed to update order status.');
    }
}
?>
