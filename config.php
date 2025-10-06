<?php
// Database configuration for XAMPP
$servername = "localhost";
$username = "root";
$password = ""; // Default XAMPP MySQL password is empty
$dbname = "food_menia";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Set charset to utf8 for proper character encoding
mysqli_set_charset($conn, "utf8");
?>