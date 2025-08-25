<?php
include_once '../config/cors.php';
include_once '../config/database.php';
include_once '../models/User.php';

$database = new Database();
$db = $database->getConnection();

$user = new User($db);

// Get posted data
$data = json_decode(file_get_contents("php://input"));

if(!empty($data->name) && !empty($data->email) && !empty($data->password)) {
    $user->name = $data->name;
    $user->email = $data->email;
    $user->password = $data->password;
    $user->role = isset($data->role) ? $data->role : 'customer';

    // Check if email already exists
    if($user->emailExists()) {
        http_response_code(400);
        echo json_encode(array("message" => "Email already exists."));
    } else {
        if($user->create()) {
            http_response_code(201);
            echo json_encode(array(
                "message" => "User registered successfully.",
                "user" => array(
                    "id" => $user->id,
                    "name" => $user->name,
                    "email" => $user->email,
                    "role" => $user->role
                )
            ));
        } else {
            http_response_code(503);
            echo json_encode(array("message" => "Unable to register user."));
        }
    }
} else {
    http_response_code(400);
    echo json_encode(array("message" => "Name, email and password are required."));
}
?>