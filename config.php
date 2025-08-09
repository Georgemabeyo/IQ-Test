<?php
// Angalia kama environment variable DATABASE_URL ipo (Render au hosting nyingine)
$databaseUrl = getenv('postgresql://iq_test_krgw_user:OgdTKE141PnrIgF8PPB1zhzAvK718bDi@dpg-d2bm45h5pdvs73ctek4g-a.oregon-postgres.render.com/iq_test_krgw');

if ($databaseUrl) {
    // Pata vipengele vya muunganisho kutoka kwenye DATABASE_URL
    $dbopts = parse_url($databaseUrl);

    $host = $dbopts["host"];
    $user = $dbopts["user"];
    $password = $dbopts["pass"];
    $database = ltrim($dbopts["path"], '/');
} else {
    // Kama uko local XAMPP, tumia settings hizi za kawaida
    $host = 'dpg-d2bm45h5pdvs73ctek4g-a';      // Local server
    $user = 'iq_test_krgw_user';           // Default XAMPP user
    $password = 'OgdTKE141PnrIgF8PPB1zhzAvK718bDi';           // Default XAMPP password (hakuna password)
    $database = 'iq_test_krgw';    // Hakikisha umeunda database hii ndani ya phpMyAdmin
}

// Unda connection
$conn = new mysqli($host, $user, $password, $database);

// Angalia kama kuna error
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

