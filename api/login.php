<?php
require('connection.php'); // Ensure this has your $con variable
header('Content-Type: application/json');

$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

if (empty($email) || empty($password)) {
    echo json_encode(["status" => "error", "message" => "Fields required"]);
    exit;
}

$secure_password = md5($password); // Matches your web logic
$res = mysqli_query($con, "SELECT * FROM users WHERE email='$email' AND password='$secure_password'");

if (mysqli_num_rows($res) > 0) {
    $row = mysqli_fetch_assoc($res);
    echo json_encode([
        "status" => "success",
        "user" => [
            "id" => $row['id'],
            "name" => $row['name'],
            "email" => $row['email'],
            "mobile" => $row['mobile']
        ]
    ]);
} else {
    echo json_encode(["status" => "error", "message" => "Invalid credentials"]);
}
?>