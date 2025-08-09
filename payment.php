<?php include 'config.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

// code yako ya kawaida inafuata hapa

session_start();
if(!isset($_SESSION['score'])){
    header("Location: index.php");
    exit();
}
$score = $_SESSION['score'];
?>
<!DOCTYPE html>
<html>
<head>
    <title>IQ Test - Payment</title>
    <link rel="stylesheet" href="style.css">
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
    </style>
</head>
<body>
<div class="container">
    <img src="IQ logo.png" alt="IQ Test Logo" class="logo" />
    <h2>Almost Done!</h2>
    <p>Your test is complete. Pay <strong>Tsh 500</strong> to view your results.</p>
    
    <h3>Choose Payment Method:</h3>
    
    <form action="result.php" method="POST">
        <button type="submit" name="pay" value="visa" class="btn">Pay with Visa/Mastercard</button>
    </form>
    
    <form action="result.php" method="POST">
        <button type="submit" name="pay" value="paypal" class="btn">Pay with PayPal</button>
    </form>
</div>
</body>
</html>
