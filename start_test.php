<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $level = $_POST['level'] ?? '';
    $subject = $_POST['subject'] ?? '';

    if (empty($level) || empty($subject)) {
        die("Level or Subject not selected. Please go back and choose.");
    }

    $_SESSION['level'] = $level;
    $_SESSION['subject'] = $subject;

    header("Location: test.php");
    exit;
} else {
    header("Location: index.php");
    exit;
}
?>
