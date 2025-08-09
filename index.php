<?php include 'config.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

// code yako ya kawaida inafuata hapa

// config.php sio lazima hapa kwenye index lakini ukiwa umeweka database unahitaji
// include 'config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>IQ Test Online</title>
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
            max-width: 500px;
            background: white;
            padding: 40px 30px;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.2);
            text-align: center;
            animation: fadeInUp 1s ease forwards;
            position: relative;
        }

        @keyframes fadeInUp {
            0% {
                opacity: 0;
                transform: translateY(40px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .logo {
            width: 120px;
            margin-bottom: 30px;
            animation: pulse 2s infinite ease-in-out;
        }

        @keyframes pulse {
            0%, 100% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.1);
            }
        }

        h1 {
            color: #222;
            font-weight: 700;
            font-size: 2.5rem;
            margin-bottom: 15px;
        }

        p {
            color: #555;
            font-size: 1.1rem;
            margin: 12px 0;
            line-height: 1.5;
        }

        .highlight {
            color: #4CAF50;
            font-weight: 700;
        }

        .btn {
            display: inline-block;
            background: #4CAF50;
            color: #fff;
            padding: 15px 40px;
            margin-top: 25px;
            text-decoration: none;
            font-size: 18px;
            border-radius: 30px;
            box-shadow: 0 8px 15px rgba(76, 175, 80, 0.3);
            transition: all 0.3s ease;
            user-select: none;
        }

        .btn:hover {
            background: #45a049;
            box-shadow: 0 12px 20px rgba(69, 160, 73, 0.5);
            transform: translateY(-3px);
            cursor: pointer;
        }

        .footer-text {
            margin-top: 20px;
            font-size: 14px;
            color: #888;
        }
    </style>
</head>
<body>
    <div class="container home">
        <img src="IQ logo.png" alt="IQ Test Logo" class="logo" />
        <h1>Welcome to the IQ Test</h1>
        <p>Take <span class="highlight">10 randomly selected questions</span> to test your intelligence level.</p>
        <a href="test.php" class="btn">Start Test</a>
        <p class="footer-text">© <?php echo date("Y"); ?> IQ Test. All rights reserved.<br>Brought to you by MabTech</p>
    </div>
</body>
</html>
