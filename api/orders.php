<?php
include "config/db.php";

$data = json_decode(file_get_contents("php://input"), true);

$user_id = $data['user_id'];
$book_id = $data['book_id'];

$sql = "INSERT INTO orders (user_id, book_id) VALUES ('$user_id', '$book_id')";
mysqli_query($con, $sql);

echo json_encode([
    "status" => "success",
    "message" => "Order placed"
]);
?>