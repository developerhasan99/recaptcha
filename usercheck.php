<?php
// Replace 'YOUR_SECRET_KEY' with your actual reCAPTCHA secret key
$recaptchaSecretKey = 'YOUR_SECRET_KEY';

// Get the reCAPTCHA token and other parameters from the request
$captchaToken = $_GET['captcha_token'];
$jsResult = $_GET['jsresult'];
$utmSource = $_GET['utm_source'];
$utmMedium = $_GET['utm_medium'];

// Set up the reCAPTCHA verification request
$verificationUrl = 'https://www.google.com/recaptcha/api/siteverify';
$verificationData = [
    'secret'   => $recaptchaSecretKey,
    'response' => $captchaToken,
];

$options = [
    'http' => [
        'header'  => 'Content-type: application/x-www-form-urlencoded',
        'method'  => 'POST',
        'content' => http_build_query($verificationData),
    ],
];

$context  = stream_context_create($options);
$response = file_get_contents($verificationUrl, false, $context);

// Decode the JSON response from reCAPTCHA API
$verificationResult = json_decode($response, true);

// Check if the reCAPTCHA verification was successful
if ($verificationResult && $verificationResult['success']) {
    // Your custom logic here, for example, logging, saving to a database, etc.

    // Output a JSON response indicating success
    echo json_encode(['success' => true, 'message' => 'reCAPTCHA verification successful']);
} else {
    // Output a JSON response indicating failure
    echo json_encode(['success' => false, 'error' => 'reCAPTCHA verification failed']);
}
?>
