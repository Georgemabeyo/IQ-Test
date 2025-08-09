<?php
// Soma details za database kutoka Environment Variables
$host = getenv("MYSQL_HOST") ?: "dpg-d2bm45h5pdvud1234-mysql.oregon-postgres.render.com";
$user = getenv("MYSQL_USER") ?: "iq_test_krgw_user";
$password = getenv("MYSQL_PASSWORD") ?: "OgdTKE141PnrIgF8PPB1zhzAvK718bDi";
$database = getenv("MYSQL_DATABASE") ?: "iq_test_krgw";
$port = getenv("MYSQL_PORT") ?: 25060; // Port ya MySQL kwenye Render

// Jaribu kuunganisha
$conn = new mysqli($host, $user, $password, $database, $port);

// Angalia kama kuna error
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

