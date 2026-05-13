<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

header("Content-Type: application/json");

include "config/db.php";

$data = json_decode(file_get_contents("php://input"), true);

/// CHECK IF DATA EXISTS
if (!$data) {

    echo json_encode([
        "status" => "error",
        "message" => "No data received"
    ]);

    exit();
}

/// GET VALUES
$email = $data['email'] ?? '';
$password = $data['password'] ?? '';

/// VALIDATE
if (empty($email) || empty($password)) {

    echo json_encode([
        "status" => "error",
        "message" => "Email and password required"
    ]);

    exit();
}

/// QUERY
$sql = "SELECT * FROM users
        WHERE email='$email'
        AND password='$password'";

$result = mysqli_query($con, $sql);

/// CHECK LOGIN
if (mysqli_num_rows($result) > 0) {

    $user = mysqli_fetch_assoc($result);

    echo json_encode([
        "status" => "success",
        "user" => $user
    ]);

} else {

    echo json_encode([
        "status" => "error",
        "message" => "Invalid credentials"
    ]);
}

?>