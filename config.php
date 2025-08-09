<?php
$host = 'dpg-d2bm45h5pdvud1234-mysql.oregon-postgres.render.com'; // External host
$port = 25060;
$user = 'iq_test_krgw_user'; 
$password = 'password_uliyopewa_na_render';
$database = 'iq_test_krgw';

// Connection
$conn = new mysqli($host, $user, $password, $database, $port);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
