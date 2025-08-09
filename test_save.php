<?php
session_start();
include 'config.php';

// Hakikisha session ya maswali ipo
if (!isset($_SESSION['questions']) || !is_array($_SESSION['questions'])) {
    die("Session expired or invalid. Please start the test again.");
}

// Hakikisha data imeletwa kupitia POST na ni sahihi
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['qid']) && isset($_POST['answer'])) {
    $qid = intval($_POST['qid']);
    $answer = strtoupper(trim($_POST['answer']));  // Hakikisha ni A, B, C au D

    // Hakikisha jibu ni mojawapo ya chaguo sahihi
    if (!in_array($answer, ['A', 'B', 'C', 'D'])) {
        die("Invalid answer choice.");
    }

    // Hifadhi jibu kwenye session
    if (!isset($_SESSION['answers'])) {
        $_SESSION['answers'] = [];
    }
    $_SESSION['answers'][$qid] = $answer;

    // Sogeza kwa swali linalofuata
    if (isset($_SESSION['current'])) {
        $_SESSION['current'] += 1;
    } else {
        $_SESSION['current'] = 1;
    }

    // Angalia kama maswali yote yamejibiwa
    if ($_SESSION['current'] >= count($_SESSION['questions'])) {
        header("Location: process.php");
        exit;
    } else {
        header("Location: test.php");
        exit;
    }
} else {
    // Ikiwa hakuna data sahihi iliyopokelewa
    echo "Invalid request.";
}
?>
