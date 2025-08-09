<?php
// Angalia kama environment variable DATABASE_URL ipo (Render au hosting nyingine)
$databaseUrl = getenv('DATABASE_URL');

if ($databaseUrl) {
    // Pata vipengele vya muunganisho kutoka kwenye DATABASE_URL
    $dbopts = parse_url($databaseUrl);

    $host = $dbopts["host"];
    $user = $dbopts["user"];
    $password = $dbopts["pass"];
    $database = ltrim($dbopts["path"], '/');
} else {
    // Kama uko local XAMPP, tumia settings hizi za kawaida
    $host = '127.0.0.1';      // Local server
    $user = 'root';           // Default XAMPP user
    $password = '';           // Default XAMPP password (hakuna password)
    $database = 'iq_test';    // Hakikisha umeunda database hii ndani ya phpMyAdmin
}

// Unda connection
$conn = new mysqli($host, $user, $password, $database);

// Angalia kama kuna error
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
