<?php include 'config.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

// code yako ya kawaida inafuata hapa

session_start();
include 'config.php';

// ✅ Thibitisha kuwa data ipo
if(empty($_SESSION['user_answers']) || empty($_SESSION['questions_list'])){
    echo "<h2 style='text-align:center;color:red;'>No answers found. Please take the test first.</h2>";
    exit();
}

$userAnswers = $_SESSION['user_answers'];
$questions = $_SESSION['questions_list'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Detailed Results</title>
    <style>
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
            margin: 40px auto;
            background: #fff;
            padding: 20px 30px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }
        .question-block {
            background: #f9f9f9;
            padding: 15px;
            margin-bottom: 15px;
            border-left: 5px solid #4CAF50;
            border-radius: 6px;
        }
        .option {
            padding: 10px;
            margin: 5px 0;
            border-radius: 5px;
        }
        .correct {
            background: #d4edda;
            border: 1px solid #28a745;
        }
        .wrong {
            background: #f8d7da;
            border: 1px solid #dc3545;
        }
        .neutral {
            background: #eee;
            border: 1px solid #ccc;
        }
        .btn {
            display: inline-block;
            background: #4CAF50;
            color: #fff;
            padding: 10px 20px;
            margin-top: 15px;
            text-decoration: none;
            font-size: 16px;
            border-radius: 5px;
        }
        .btn:hover {
            background: #45a049;
            cursor: pointer;
        }
    </style>
</head>
<body>
<div class="container">
    <img src="IQ logo.png" alt="IQ Test Logo" class="logo" />
    <h2>Detailed Answers</h2>
    <?php
    foreach($questions as $qid){
        $sql = "SELECT * FROM questions WHERE id = $qid";
        $res = $conn->query($sql);
        if($res && $q = $res->fetch_assoc()){
            $correct = $q['correct_answer'];
            $userAns = isset($userAnswers[$qid]) ? $userAnswers[$qid] : null;

            echo "<div class='question-block'>";
            echo "<p><strong>".htmlspecialchars($q['question'])."</strong></p>";

            foreach(['A','B','C','D'] as $opt){
                $optionText = $q['option_'.strtolower($opt)];
                $class = 'neutral';
                if($opt == $correct) $class = 'correct';
                if($userAns == $opt && $opt != $correct) $class = 'wrong';

                echo "<div class='option $class'>$opt) ".htmlspecialchars($optionText)."</div>";
            }
            echo "</div>";
        }
    }
    ?>
    <a href="index.php" class="btn">Take Test Again</a>
</div>
</body>
</html>
