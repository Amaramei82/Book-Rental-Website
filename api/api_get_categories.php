<?php
require('connection.php'); 
header('Content-Type: application/json');

// Exact same logic as your categories.php: Active categories only
$sql = "SELECT id, category FROM categories WHERE status = 1 ORDER BY category ASC";
$res = mysqli_query($con, $sql);
$categories = [];

while ($row = mysqli_fetch_assoc($res)) {
    $categories[] = [
        "id" => $row['id'],
        "name" => $row['category']
    ];
}

echo json_encode($categories);
?>