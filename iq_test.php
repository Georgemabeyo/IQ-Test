<?php include 'config.php';
$servername = "localhost"; // au 127.0.0.1
$username = "root";        // badilisha kama si root
$password = "";            // kama una password, weka hapa
$dbname = "iq_test";

// Unda muunganisho (connection)
$conn = new mysqli($servername, $username, $password, $dbname);

// Angalia kama kuna kosa
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
