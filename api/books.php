<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

header("Content-Type: application/json");

include "config/db.php";

$sql = "SELECT * FROM books";
$result = mysqli_query($con, $sql);

$books = [];

while ($row = mysqli_fetch_assoc($result)) {
    $books[] = $row;
}

echo json_encode([
    "status" => "success",
    "data" => $books
]);

?>