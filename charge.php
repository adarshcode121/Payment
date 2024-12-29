<?php
require 'vendor/autoload.php';

use Razorpay\Api\Api;

// Replace with your Razorpay Key ID and Key Secret
$keyId = 'rzp_test_44kONeFWXachHi';
$keySecret = '6RZqUjyGoKLJDSX7iXB7WhUX';

$api = new Api($keyId, $keySecret);

// Check if necessary POST data is set
if (!isset($_POST['razorpay_payment_id']) || !isset($_POST['amount'])) {
    $error = "Payment ID or amount is missing!";
    echo $error;
    file_put_contents('payment.log', date('Y-m-d H:i:s') . " - Error: " . $error . "\n", FILE_APPEND);
    exit;
}

// Get the payment details
$paymentId = $_POST['razorpay_payment_id'];
$amount = $_POST['amount']; // Amount in paisa

try {
    // Fetch the payment object
    $payment = $api->payment->fetch($paymentId);

    // Capture the payment
    $payment->capture(['amount' => $amount]);

    // Payment successfully captured
    $success = "Payment successful!";
    echo $success;
    file_put_contents('payment.log', date('Y-m-d H:i:s') . " - Success: Payment successful: " . $paymentId . "\n", FILE_APPEND);
} catch (\Exception $e) {
    // Payment failed
    $error = "Payment failed: " . $e->getMessage();
    echo $error;
    file_put_contents('payment.log', date('Y-m-d H:i:s') . " - Error: " . $error . "\n", FILE_APPEND);
}
?>