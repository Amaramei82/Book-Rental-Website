header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
<?php
header("Content-Type: application/json");
include "config/db.php";

$sql = "SELECT * FROM books";
$result = $conn->query($sql);

$books = [];

while ($row = $result->fetch_assoc()) {
    $books[] = $row;
}

echo json_encode([
    "status" => "success",
    "data" => $books
]);
?>