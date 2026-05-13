<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

// Database connection
$con = mysqli_connect("localhost:3307", "root", "", "book-rental-website");

// Check connection
if (!$con) {
    echo json_encode([
        "status" => "error",
        "message" => "Database connection failed",
        "error" => mysqli_connect_error()
    ]);
    exit();
}

// Optional: set charset (important for mobile apps)
mysqli_set_charset($con, "utf8mb4");
?>