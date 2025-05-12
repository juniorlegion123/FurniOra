<?php
require_once __DIR__.'/../vendor/autoload.php';
use Razorpay\Api\Api;

// Razorpay API credentials
define('RAZORPAY_KEY_ID', 'rzp_live_GMPTAi3TWJL16X');
define('RAZORPAY_KEY_SECRET', 'T7nERw33eG9wPl1tMvKGYJM6');

$api = new Api(RAZORPAY_KEY_ID, RAZORPAY_KEY_SECRET);

/**
 * Creates a Razorpay order
 */
function createRazorpayOrder($amount, $receipt) {
    global $api;
    
    try {
        $order = $api->order->create([
            'receipt' => $receipt,
            'amount' => $amount * 100, // Razorpay expects amount in paise
            'currency' => 'INR',
            'payment_capture' => 1
        ]);
        
        return $order;
    } catch (Exception $e) {
        error_log("Razorpay Order Error: " . $e->getMessage());
        throw new Exception("Payment processing error");
    }
}

/**
 * Verifies Razorpay payment signature
 */
// In razorpay-config.php
function verifyRazorpayPayment($attributes) {
    $razorpay_payment_id = $attributes['razorpay_payment_id'];
    $razorpay_order_id = $attributes['razorpay_order_id'];
    $razorpay_signature = $attributes['razorpay_signature'];
    
    // Verify signature
    $generated_signature = hash_hmac('sha256', $razorpay_order_id.'|'.$razorpay_payment_id, RAZORPAY_KEY_SECRET);
    
    if ($generated_signature === $razorpay_signature) {
        // Additional check - verify payment with Razorpay API
        $api = new Api(RAZORPAY_KEY_ID, RAZORPAY_KEY_SECRET);
        $payment = $api->payment->fetch($razorpay_payment_id);
        return $payment->status === 'captured';
    }
    
    error_log("Signature verification failed for payment: $razorpay_payment_id");
    return false;
}