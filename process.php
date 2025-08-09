<?php include 'config.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

// code yako ya kawaida inafuata hapa


session_start();
include 'config.php';

if (!isset($_SESSION['answers']) || !isset($_SESSION['questions'])) {
    echo "No data available. Please take the test first.";
    exit;
}

$answers = $_SESSION['answers'];
$questions = $_SESSION['questions'];

$score = 0;
$user_answers = [];
$questions_data = [];

$ids_str = implode(',', array_map('intval', $questions));
$query = "SELECT * FROM questions WHERE id IN ($ids_str)";
$result = mysqli_query($conn, $query);
if (!$result) {
    die("Database error: " . mysqli_error($conn));
}

while ($row = mysqli_fetch_assoc($result)) {
    $questions_data[$row['id']] = $row;
}

foreach ($questions as $qid) {
    $qid = intval($qid);
    if (isset($answers[$qid])) {
        $user_answer = strtoupper(trim($answers[$qid]));
        $correct_answer = strtoupper($questions_data[$qid]['correct_answer']);
        if ($user_answer === $correct_answer) {
            $score++;
        }
        $user_answers[$qid] = $user_answer;
    } else {
        $user_answers[$qid] = null;
    }
}

$iq_level = 80 + ($score * 8);

if ($iq_level >= 130) {
    $comment = "Super Intelligent";
} elseif ($iq_level >= 115) {
    $comment = "Very Above Average";
} elseif ($iq_level >= 90) {
    $comment = "Average";
} elseif ($iq_level >= 70) {
    $comment = "Below Average";
} else {
    $comment = "Needs Improvement";
}

session_destroy();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<title>IQ Test Results</title>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap');

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
        max-width: 800px;
        background: white;
        padding: 40px 30px;
        border-radius: 20px;
        box-shadow: 0 20px 40px rgba(0,0,0,0.2);
        animation: fadeInUp 1s ease forwards;
        text-align: center;
    }

    @keyframes fadeInUp {
        0% { opacity: 0; transform: translateY(40px); }
        100% { opacity: 1; transform: translateY(0); }
    }

    .logo {
        width: 120px;
        margin-bottom: 30px;
        animation: pulse 2s infinite ease-in-out;
    }

    @keyframes pulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.1); }
    }

    h1 {
        color: #222;
        font-weight: 700;
        font-size: 2.2rem;
        margin-bottom: 15px;
    }

    .summary {
        font-size: 18px;
        margin-bottom: 12px;
        color: #333;
    }

    .comment {
        font-weight: bold;
        font-size: 22px;
        color: #007700;
        margin-bottom: 30px;
    }

    .question-block {
        background: #f9f9f9;
        padding: 15px;
        margin-bottom: 15px;
        border-left: 6px solid #4CAF50;
        border-radius: 6px;
        text-align: left;
    }

    .question-text {
        font-weight: bold;
        margin-bottom: 12px;
        color: #444;
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

    a.btn {
        display: inline-block;
        margin-top: 30px;
        padding: 14px 30px;
        background: #4CAF50;
        color: white;
        text-align: center;
        font-size: 18px;
        border-radius: 8px;
        text-decoration: none;
        font-weight: bold;
        box-shadow: 0 8px 15px rgba(76, 175, 80, 0.3);
        transition: all 0.3s ease;
    }

    a.btn:hover {
        background: #45a049;
        box-shadow: 0 12px 20px rgba(69, 160, 73, 0.5);
        transform: translateY(-3px);
    }
</style>
</head>
<body>
<div class="container">
    <img src="IQ logo.png" alt="IQ Test Logo" class="logo" />
    <h1>Your IQ Test Results</h1>

    <div class="summary">
        You answered <strong><?php echo $score; ?></strong> out of <strong><?php echo count($questions); ?></strong> questions correctly.<br>
        Estimated IQ Level: <strong><?php echo $iq_level; ?></strong>
    </div>

    <div class="comment"><?php echo $comment; ?></div>

    <?php foreach ($questions as $qid): 
        $q = $questions_data[$qid];
        $correct = strtoupper($q['correct_answer']);
        $user = isset($user_answers[$qid]) ? strtoupper($user_answers[$qid]) : null;
    ?>
        <div class="question-block">
            <div class="question-text"><?php echo htmlspecialchars($q['question']); ?></div>
            <?php foreach(['A','B','C','D'] as $opt): 
                $class = "neutral";
                if ($opt == $correct) {
                    $class = "correct";
                }
                if ($opt == $user && $opt != $correct) {
                    $class = "wrong";
                }
            ?>
                <div class="option <?php echo $class; ?>">
                    <?php echo $opt . ') ' . htmlspecialchars($q['option_' . strtolower($opt)]); ?>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endforeach; ?>

    <a href="index.php" class="btn">Take Test Again</a>
    <p class="footer-text">© <?php echo date("Y"); ?> IQ Test. All rights reserved.<br>Brought to you by MabTech</p>
</div>
</body>
</html>
