<?php
// Include your existing database connection ($con)
require('connection.php'); 

header('Content-Type: application/json');

// We use the exact same SQL logic from your admin panel
$sql = "SELECT books.*, categories.category 
        FROM books 
        LEFT JOIN categories ON books.category_id=categories.id 
        WHERE books.status = 1 
        ORDER BY books.name ASC";

$res = mysqli_query($con, $sql);
$books = [];

while ($row = mysqli_fetch_assoc($res)) {
    // Ensure the image path is a full URL so Flutter can load it
    $row['img_url'] = BOOK_IMAGE_SITE_PATH . $row['img'];
    $books[] = $row;
}

echo json_encode($books);
?>