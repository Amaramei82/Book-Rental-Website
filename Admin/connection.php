<?php
  if (session_status() === PHP_SESSION_NONE) {
      session_start();
  }

  $con = mysqli_connect('localhost:3307', 'root', '', 'book-rental-website');

  if (!$con) {
      die("Connection failed: " . mysqli_connect_error());
  }

  // --- PATH DEFINITIONS ---
  
  // 1. Physical path on your hard drive
  // We add the project folder name so it doesn't just stop at 'htdocs'
  define('SERVER_PATH', $_SERVER['DOCUMENT_ROOT'] . '/book-rental-website/');

  // 2. The URL used in the browser 
  // Fixed the double slashes here
  const SITE_PATH = 'http://localhost/Book-Rental-Website/';

  // 3. Image Paths (Cleaned up slashes)
  const BOOK_IMAGE_SERVER_PATH = SERVER_PATH . 'Img/books/';
  const BOOK_IMAGE_SITE_PATH = SITE_PATH . 'Img/books/';
?>