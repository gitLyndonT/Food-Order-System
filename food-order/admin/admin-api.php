<?php
// Include database connection
include('config/config.php');

// Set headers for API response
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

// Check the request method
$request_method = $_SERVER["REQUEST_METHOD"];

switch($request_method) {
    case 'GET':
        getAdmins();
        break;
    
    case 'POST':
        addAdmin();
        break;

    case 'PUT':
        updateAdmin();
        break;

    case 'DELETE':
        deleteAdmin();
        break;

    default:
        echo json_encode(["message" => "Method Not Allowed"]);
        break;
}

function getAdmins() {
    global $conn;
    
    $sql = "SELECT * FROM tbl_admin";
    $res = mysqli_query($conn, $sql);
    
    if($res) {
        $admins = [];
        
        while($row = mysqli_fetch_assoc($res)) {
            $admins[] = $row;
        }
        
        echo json_encode($admins);
    } else {
        echo json_encode(["message" => "No admins found."]);
    }
}

function addAdmin() {
    global $conn;
    
    $data = json_decode(file_get_contents("php://input"));
    
    if(isset($data->full_name) && isset($data->username) && isset($data->password)) {
        $full_name = mysqli_real_escape_string($conn, $data->full_name);
        $username = mysqli_real_escape_string($conn, $data->username);
        $password = mysqli_real_escape_string($conn, $data->password);
        
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        $sql = "INSERT INTO tbl_admin (full_name, username, password) VALUES ('$full_name', '$username', '$hashed_password')";
        
        if(mysqli_query($conn, $sql)) {
            echo json_encode(["message" => "Admin added successfully."]);
        } else {
            echo json_encode(["message" => "Failed to add admin."]);
        }
    } else {
        echo json_encode(["message" => "Missing required fields."]);
    }
}

function updateAdmin() {
    global $conn;
    
    $data = json_decode(file_get_contents("php://input"));
    
    if(isset($data->id) && isset($data->full_name) && isset($data->username)) {
        $id = mysqli_real_escape_string($conn, $data->id);
        $full_name = mysqli_real_escape_string($conn, $data->full_name);
        $username = mysqli_real_escape_string($conn, $data->username);
        
        $sql = "UPDATE tbl_admin SET full_name='$full_name', username='$username' WHERE id=$id";
        
        if(mysqli_query($conn, $sql)) {
            echo json_encode(["message" => "Admin updated successfully."]);
        } else {
            echo json_encode(["message" => "Failed to update admin."]);
        }
    } else {
        echo json_encode(["message" => "Missing required fields."]);
    }
}

function deleteAdmin() {
    global $conn;
    
    $data = json_decode(file_get_contents("php://input"));
    
    if(isset($data->id)) {
        $id = mysqli_real_escape_string($conn, $data->id);
        
        $sql = "DELETE FROM tbl_admin WHERE id=$id";
        
        if(mysqli_query($conn, $sql)) {
            echo json_encode(["message" => "Admin deleted successfully."]);
        } else {
            echo json_encode(["message" => "Failed to delete admin."]);
        }
    } else {
        echo json_encode(["message" => "Missing required fields."]);
    }
}
?>
