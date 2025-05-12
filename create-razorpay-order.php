<?php
include("includes/db.php");
include("includes/razorpay-config.php");

$amount = floatval($_GET['amount']);
$customer_id = intval($_GET['customer_id']);

// Validate inputs
if($amount <= 0 || $customer_id <= 0) {
    http_response_code(400);
    die(json_encode(['error' => 'Invalid amount or customer ID']));
}

try {
    // Create order in Razorpay
    $order = createRazorpayOrder($amount, 'order_'.$customer_id);
    
    // Return order details as JSON
    header('Content-Type: application/json');
    echo json_encode([
        'id' => $order->id,
        'amount' => $order->amount,
        'currency' => $order->currency
    ]);
} catch(Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
?>
