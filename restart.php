<?php include 'config.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

// code yako ya kawaida inafuata hapa

session_start();
session_destroy();
header("Location: test.php"); // au jina la ukurasa huu wa test
exit;
?>
