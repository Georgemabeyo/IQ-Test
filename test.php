<?php include 'config.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

// code yako ya kawaida inafuata hapa

session_start();
include 'config.php';

// Define total time for the whole test (sekunde 60 hapa, badilisha kama unataka)
define('TOTAL_TIME', 120);

// Weka wakati wa kuanza test kama haijaanzishwa
if (!isset($_SESSION['questions'])) {
    $sql = "SELECT id FROM questions ORDER BY RAND() LIMIT 10";
    $result = $conn->query($sql);
    $questions = [];
    while ($row = $result->fetch_assoc()) {
        $questions[] = $row['id'];
    }
    $_SESSION['questions'] = $questions;
    $_SESSION['current'] = 0;
    $_SESSION['answers'] = [];

    $_SESSION['time_start'] = time(); // Weka wakati wa kuanza test sasa
}

$current = $_SESSION['current'];
$questions = $_SESSION['questions'];

// Endelea kama kawaida
if ($current >= count($questions)) {
    header("Location: results.php");
    exit;
}

// Hesabu muda uliobaki
$time_passed = time() - $_SESSION['time_start'];
$time_left = TOTAL_TIME - $time_passed;
if ($time_left < 0) $time_left = 0;

$qid = $questions[$current];
$sql = "SELECT * FROM questions WHERE id = $qid";
$res = $conn->query($sql);
$q = $res->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>IQ Test - Question <?php echo $current + 1; ?></title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap');

        body {
            font-family: 'Poppins', Arial, sans-serif;
            background: linear-gradient(135deg, rgb(221, 221, 196) 0%);
            margin: 0;
            padding: 30px 0;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .top-logo {
            width: 100px;
            margin-bottom: 20px;
            animation: pulse 2s infinite ease-in-out;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.1); }
        }

        .container {
            max-width: 700px;
            width: 90%;
            background: #fff;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.2);
            animation: fadeInUp 0.8s ease forwards;
            position: relative;
        }

        @keyframes fadeInUp {
            0% { opacity: 0; transform: translateY(40px); }
            100% { opacity: 1; transform: translateY(0); }
        }

        h2 {
            margin-bottom: 15px;
            color: #333;
            text-align: center;
            font-size: 24px;
        }

        .message {
            font-size: 18px;
            color: #007700;
            margin-bottom: 15px;
            font-weight: bold;
            text-align: center;
        }

        .error {
            font-size: 16px;
            color: red;
            margin-bottom: 15px;
            text-align: center;
        }

        .question-text {
            font-size: 20px;
            margin-bottom: 25px;
            text-align: center;
        }

        .options {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .option-btn {
            background: #eee;
            padding: 15px 20px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 18px;
            border: 2px solid transparent;
            transition: all 0.3s ease;
        }

        .option-btn:hover {
            background: #ddd;
        }

        .option-btn.selected {
            background: #4CAF50;
            color: white;
            border-color: #388E3C;
        }

        form {
            margin-top: 30px;
            text-align: center;
        }

        button.btn {
            background: #4CAF50;
            color: white;
            border: none;
            padding: 14px 35px;
            font-size: 18px;
            border-radius: 6px;
            cursor: pointer;
            display: none;
            margin-top: 20px;
            box-shadow: 0 8px 15px rgba(76, 175, 80, 0.3);
        }

        button.btn.visible {
            display: inline-block;
        }

        #timer {
            text-align:center; 
            font-size: 20px; 
            margin-bottom: 15px; 
            color:#d80000;
            font-weight: bold;
        }

        #timeUpOptions {
            display: none;
            margin-top: 20px;
            text-align: center;
        }

        #timeUpOptions button {
            background: #007BFF;
            color: white;
            border: none;
            padding: 12px 25px;
            font-size: 18px;
            border-radius: 8px;
            cursor: pointer;
            margin: 10px;
            transition: background-color 0.3s ease;
        }

        #timeUpOptions button:hover {
            background-color: #0056b3;
        }

        @media screen and (max-width: 600px) {
            .question-text { font-size: 18px; }
            .option-btn { font-size: 16px; }
            button.btn { font-size: 16px; padding: 12px 25px; }
        }
    </style>
</head>
<body>

    <img src="IQ logo.png" alt="IQ Test Logo" class="top-logo" />

    <div class="container">
        <div id="timer">Time Remaining: <span id="time"><?php echo $time_left; ?></span> seconds</div>

        <h2>Question <?php echo $current + 1; ?> of <?php echo count($questions); ?></h2>

        <?php if ($current == 3): ?>
            <div class="message">Great job! Keep going, you are doing well!</div>
        <?php elseif ($current == 7): ?>
            <div class="message">Awesome! You are among the top performers!</div>
        <?php endif; ?>

        <div class="question-text"><?php echo htmlspecialchars($q['question']); ?></div>

        <form method="post" action="test_save.php" id="quizForm" onsubmit="return validateAnswer()">
            <input type="hidden" name="qid" value="<?php echo $qid; ?>">
            <input type="hidden" name="answer" id="answerInput" value="">

            <div class="options">
                <?php foreach(['A','B','C','D'] as $opt): ?>
                    <div class="option-btn" data-value="<?php echo $opt; ?>">
                        <?php echo $opt . ') ' . htmlspecialchars($q['option_' . strtolower($opt)]); ?>
                    </div>
                <?php endforeach; ?>
            </div>

            <div id="errorMsg" class="error" style="display:none;">Please select an answer before proceeding.</div>

            <button type="submit" class="btn" id="nextBtn">
                <?php echo ($current == count($questions) - 1) ? 'Submit' : 'Next'; ?>
            </button>
        </form>

        <div id="timeUpOptions">
            <p><strong>Time is up!</strong></p>
            <button id="restartBtn">Restart Again</button>
            <button id="resultsBtn">View The Results</button>
        </div>
    </div>

<script>
    const options = document.querySelectorAll('.option-btn');
    const answerInput = document.getElementById('answerInput');
    const nextBtn = document.getElementById('nextBtn');
    const errorMsg = document.getElementById('errorMsg');
    const quizForm = document.getElementById('quizForm');
    const timerDiv = document.getElementById('timer');
    const timeUpOptions = document.getElementById('timeUpOptions');

    options.forEach(option => {
        option.addEventListener('click', () => {
            options.forEach(o => o.classList.remove('selected'));
            option.classList.add('selected');
            answerInput.value = option.getAttribute('data-value');
            nextBtn.classList.add('visible');
            errorMsg.style.display = 'none';
        });
    });

    function validateAnswer() {
        if (answerInput.value === '') {
            errorMsg.style.display = 'block';
            return false;
        }
        return true;
    }

    // Timer setup
    let timeLeft = <?php echo $time_left; ?>; 
    const timeDisplay = document.getElementById('time');

    const countdown = setInterval(() => {
        timeLeft--;
        timeDisplay.textContent = timeLeft;

        if (timeLeft <= 0) {
            clearInterval(countdown);
            timerDiv.style.display = 'none';
            quizForm.style.display = 'none';
            timeUpOptions.style.display = 'block';
        }
    }, 1000);

    // Button actions
    document.getElementById('restartBtn').addEventListener('click', () => {
        window.location.href = 'restart.php';
    });

    document.getElementById('resultsBtn').addEventListener('click', () => {
        window.location.href = 'result.php';
    });
</script>

</body>
</html>
