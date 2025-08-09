<?php
// Makubaliano ya XAMPP default
$host = 'localhost';     // Local server
$user = 'root';          // Default XAMPP user
$password = '';          // Default XAMPP password (hakuna password)
$database = 'iq_test';   // Hakikisha umeunda hii database ndani ya phpMyAdmin

// Unda connection
$conn = new mysqli($host, $user, $password, $database);

// Angalia kama kuna error
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
