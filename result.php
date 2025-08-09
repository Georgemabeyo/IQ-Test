<?php
include 'config.php';
session_start();

if (!isset($_SESSION['questions']) || !isset($_SESSION['answers'])) {
    header("Location: index.php");
    exit;
}

$questions = $_SESSION['questions'];
$userAnswers = $_SESSION['answers'];
$totalQuestions = count($questions);
$score = 0;
$detailedResults = [];

$ids_str = implode(',', array_map('intval', $questions));
$sql = "SELECT * FROM questions WHERE id IN ($ids_str)";
$result = $conn->query($sql);

if (!$result) {
    die("Database error: " . $conn->error);
}

$questionsData = [];
while ($row = $result->fetch_assoc()) {
    $questionsData[$row['id']] = $row;
}

foreach ($questions as $qid) {
    $q = $questionsData[$qid];
    $correctAnswer = $q['correct_answer'];
    $userAnswer = $userAnswers[$qid] ?? null;

    if ($userAnswer === $correctAnswer) {
        $score++;
    }

    $detailedResults[] = [
        'question' => $q['question'],
        'options' => [
            'A' => $q['option_a'],
            'B' => $q['option_b'],
            'C' => $q['option_c'],
            'D' => $q['option_d'],
        ],
        'correct' => $correctAnswer,
        'user' => $userAnswer
    ];
}

$estimatedIQ = 80 + ($score * 8);

if ($estimatedIQ >= 130) {
    $comment = "Super Intelligent";
} elseif ($estimatedIQ >= 115) {
    $comment = "Very Above Average";
} elseif ($estimatedIQ >= 90) {
    $comment = "Average";
} elseif ($estimatedIQ >= 70) {
    $comment = "Below Average";
} else {
    $comment = "Needs Improvement";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>IQ Test Results</title>
<style>
    * {
        box-sizing: border-box;
    }
    html, body {
        margin: 0;
        padding: 0;
        min-height: 100vh;
        font-family: 'Poppins', Arial, sans-serif;
        font-size: 16px;
        background: linear-gradient(135deg, rgb(221, 221, 196) 0%);
        display: flex;
        flex-direction: column;
    }

    .container {
        max-width: 900px;
        width: 90%;
        margin: 30px auto 20px;
        background: white;
        padding: 20px 30px;
        border-radius: 10px;
        box-shadow: 0 3px 8px rgba(0,0,0,0.1);
    }

    .logo {
        display: block;
        margin: 30px auto 10px;
        max-width: 150px;
        height: auto;
        animation: float 3s ease-in-out infinite;
    }

    @keyframes float {
        0%   { transform: translateY(0); }
        50%  { transform: translateY(-15px); }
        100% { transform: translateY(0); }
    }

    h2 {
        text-align: center;
        color: #333;
        margin-bottom: 10px;
    }

    .summary, .comment {
        text-align: center;
        margin-bottom: 30px;
    }

    .summary {
        font-size: 18px;
    }

    .comment {
        font-weight: bold;
        font-size: 20px;
        color: #007700;
    }

    .question-block {
        background: #f9f9f9;
        padding: 15px;
        margin-bottom: 15px;
        border-left: 6px solid #4CAF50;
        border-radius: 6px;
    }

    .question-text {
        font-weight: bold;
        margin-bottom: 12px;
    }

    .option {
        padding: 10px 15px;
        margin: 4px 0;
        border-radius: 5px;
        border: 1px solid #ccc;
    }

    .correct {
        background-color: #d4edda;
        border-color: #28a745;
        color: #155724;
        font-weight: bold;
    }

    .wrong {
        background-color: #f8d7da;
        border-color: #dc3545;
        color: #721c24;
    }

    .neutral {
        background-color: #eee;
    }

    .btn {
        display: block;
        max-width: 220px;
        margin: 30px auto 0;
        padding: 14px 25px;
        background: #4CAF50;
        color: white;
        text-align: center;
        font-size: 18px;
        border-radius: 8px;
        text-decoration: none;
    }

    .btn:hover {
        background: #45a049;
    }

    .footer {
        text-align: center;
        padding: 20px 0;
        color: #555;
        font-size: 14px;
        background: transparent;
    }
</style>
</head>
<body>

<img src="IQ logo.png" alt="IQ Test Logo" class="logo">

<div class="container">
    <h2>IQ Test Results</h2>
    <div class="summary">
        You answered <strong><?= $score; ?></strong> out of <strong><?= $totalQuestions; ?></strong> questions correctly.<br>
        Estimated IQ Level: <strong><?= $estimatedIQ; ?></strong>
    </div>
    <div class="comment"><?= $comment; ?></div>

    <?php foreach ($detailedResults as $item): ?>
        <div class="question-block">
            <div class="question-text"><?= htmlspecialchars($item['question']); ?></div>
            <?php foreach ($item['options'] as $opt => $text):
                $class = 'neutral';
                if ($opt === $item['correct']) $class = 'correct';
                if ($opt === $item['user'] && $opt !== $item['correct']) $class = 'wrong';
            ?>
                <div class="option <?= $class; ?>">
                    <?= $opt . ') ' . htmlspecialchars($text); ?>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endforeach; ?>

    <a href="index.php" class="btn">Take Test Again</a>
</div>

<div class="footer">
    © <?= date("Y"); ?> IQ Test. All rights reserved.<br>
    Brought to you by MabTech
</div>

</body>
</html>
