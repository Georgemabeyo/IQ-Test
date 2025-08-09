<?php
session_start();

if (isset($_POST['answer'])) {
    $_SESSION['answers'][] = $_POST['answer'];
    $_SESSION['current']++;

    header("Location: test.php");
    exit;
} else {
    echo "Please select an answer.";
}
