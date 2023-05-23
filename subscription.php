<?php
include 'header.php';
include 'config.php';
?>
<?php
// Start session to store subscription status
session_start();

// Check if user is already subscribed
if (isset($_SESSION['subscribed']) && $_SESSION['subscribed'] === true) {
    // If subscribed, allow them to download the video
    header('Content-type: video/mp4');
    header('Content-Disposition: attachment; filename="example_video.mp4"');
    readfile('path/to/example_video.mp4');
    exit();
}

// Check if the form has been submitted and payment has been made
if (isset($_POST['subscribe']) && isset($_POST['mpesa_transaction_id'])) {
    // TODO: Verify that payment has been made successfully using the MPESA API
    // If payment has been made successfully, mark user as subscribed and allow them to download the video
    $_SESSION['subscribed'] = true;
    header('Content-type: video/mp4');
    header('Content-Disposition: attachment; filename="example_video.mp4"');
    readfile('path/to/example_video.mp4');
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Subscription Page</title>
    <style>
       
    </style>
</head>
<body>
<h1>Subscribe to Download The Video</h1>
<h2><img src ="images/pay.png"> 
Please pay 5 shillings only using MPESA to subscribe and download the video.</h2>
<h3>To deposit from mpesa:</h3>
<ol>
    <li>Go to Mpesa.</li>
    <li>Select Lipa Na Mpesa.</li>
    <li>Buy Goods & Services.</li>
    <li>Enter Till Number: ############.</li>
    <li>Enter Amount: 5 shillings.</li>
    <li>Enter your pin and Confirm.</li>
    <li>Enter The Transaction Code where you are prompted below.</li>
    <li>Click on Subscribe.</li>
</ol>
<form method="POST">
    <input type="text" name="mpesa_transaction_id" placeholder="MPESA Transaction ID" required>
    <button type="submit" name="subscribe">Subscribe</button>
</form>
</body>
</html>
<style>
        <?php include 'styles.css' ?>
    </style>