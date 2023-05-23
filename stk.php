<?php
include 'config.php';
include 'header.php';
?>
<?php
// M-Pesa API credentials
$consumer_key = 'your_consumer_key';
$consumer_secret = 'your_consumer_secret';
$shortcode = 'your_shortcode';
$passkey = 'your_passkey';

// Subscription plan details
$plan_id = 'your_plan_id';
$amount = '10';
$currency = 'KES';
$description = 'Monthly subscription';

// STK push API endpoint
$url = 'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest';

// Generate timestamp
$timestamp = date('YmdHis');

// Generate password
$password = $shortcode . $passkey . $timestamp;
$password = sha1($password);

// Generate request payload
$payload = array(
    'BusinessShortCode' => $shortcode,
    'Password' => $password,
    'Timestamp' => $timestamp,
    'TransactionType' => 'CustomerPayBillOnline',
    'Amount' => $amount,
    'PartyA' => '254712345678',
    'PartyB' => $shortcode,
    'PhoneNumber' => '254712345678',
    'CallBackURL' => 'https://your-callback-url.com',
    'AccountReference' => 'your_account_reference',
    'TransactionDesc' => $description,
    'SubscriptionDetails' => array(
        'planIdentification' => $plan_id,
        'planAmount' => $amount,
        'planInterval' => 'MONTHLY',
        'startDate' => date('YmdHis'),
        'endDate' => date('YmdHis', strtotime('+30 days'))
    )
);

// Encode payload to JSON
$payload = json_encode($payload);

// Generate access token
$credentials = base64_encode($consumer_key . ':' . $consumer_secret);
$auth_url = 'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';
$auth_headers = array(
    'Authorization: Basic ' . $credentials,
    'Content-Type: application/json'
);
$auth_response = json_decode(curl_post($auth_url, null, $auth_headers));
$access_token = $auth_response->access_token;

// Send request to API
$headers = array(
    'Authorization: Bearer ' . $access_token,
    'Content-Type: application/json'
);
$response = json_decode(curl_post($url, $payload, $headers));

// Handle response
if ($response->ResponseCode == '0') {
    // Payment request successful, update subscription status
    echo 'Payment request successful';
} else {
    // Payment request failed
    echo 'Payment request failed';
}

// Helper function to send HTTP POST request
function curl_post($url, $data, $headers) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    $response = curl_exec($ch);
    curl_close($ch);
    return $response;
}

?>
 <style>
        <?php include 'styles.css' ?>
    </style>