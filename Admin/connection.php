<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$con = mysqli_connect("localhost:3307", "root", "", "book-rental-website");

if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

define('SERVER_PATH', $_SERVER['DOCUMENT_ROOT'].'/book-rental-website/');
define('SITE_PATH', 'http://localhost/book-rental-website/');

define('BOOK_IMAGE_SERVER_PATH', SERVER_PATH.'Img/books/');
define('BOOK_IMAGE_SITE_PATH', SITE_PATH.'Img/books/');
?>