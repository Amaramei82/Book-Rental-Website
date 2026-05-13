<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

header("Content-Type: application/json");

include "config/db.php";

$data = json_decode(file_get_contents("php://input"), true);

if (!$data) {
    echo json_encode([
        "status" => "error",
        "message" => "No data received"
    ]);
    exit();
}

$user_id = $data['user_id'] ?? '';
$book_id = $data['book_id'] ?? '';
$address = $data['address'] ?? '';
$payment_method = $data['payment_method'] ?? 'Cash';

if (empty($user_id) || empty($book_id)) {

    echo json_encode([
        "status" => "error",
        "message" => "Missing required fields"
    ]);

    exit();
}

$date = date("Y-m-d H:i:s");

/// CREATE ORDER
$orderQuery = "
INSERT INTO orders
(user_id, address, payment_method, payment_status, order_status, date)
VALUES
('$user_id', '$address', '$payment_method', 'pending', '1', '$date')
";

$orderResult = mysqli_query($con, $orderQuery);

if (!$orderResult) {

    echo json_encode([
        "status" => "error",
        "message" => mysqli_error($con)
    ]);

    exit();
}

$order_id = mysqli_insert_id($con);

/// INSERT ORDER DETAILS
$detailQuery = "
INSERT INTO order_detail
(order_id, book_id)
VALUES
('$order_id', '$book_id')
";

$detailResult = mysqli_query($con, $detailQuery);

if (!$detailResult) {

    echo json_encode([
        "status" => "error",
        "message" => mysqli_error($con)
    ]);

    exit();
}

/// REDUCE BOOK QTY
mysqli_query($con, "
UPDATE books
SET qty = qty - 1
WHERE id = '$book_id'
");

echo json_encode([
    "status" => "success",
    "message" => "Order placed successfully",
    "order_id" => $order_id
]);

?>