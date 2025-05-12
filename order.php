<?php
session_start();
include("includes/db.php");
include("functions/functions.php");
include("includes/razorpay-config.php");

// Verify database connection
if(!$con) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Make sure Razorpay SDK is properly included
require_once __DIR__.'/vendor/autoload.php'; // Path to your Razorpay SDK autoload
use Razorpay\Api\Api;

$payment_method = 'COD'; // Default
if(isset($_GET['payment_method'])) {
    $payment_method = $_GET['payment_method'];
} elseif(isset($_GET['payment_id'])) {
    $payment_method = 'Razorpay';
}

// Getting customer
if(isset($_GET['c_id'])){
    $customer_id = $_GET['c_id'];
    
    // Verify customer exists
    $c_email = "SELECT * FROM customers WHERE customer_id='$customer_id'";
    $run_email = mysqli_query($con, $c_email);
    
    if($run_email && mysqli_num_rows($run_email) > 0) {
        $r_email = mysqli_fetch_array($run_email);
        $customer_email = $r_email['customer_email'];
        $customer_name = $r_email['customer_name'];
    } else {
        die("Customer not found");
    }
} else {
    die("Customer ID not provided");
}

// Handle Razorpay payment verification
if($payment_method === 'Razorpay' && isset($_GET['payment_id'])) {
    $payment_id = $_GET['payment_id'];
    $order_id = isset($_GET['order_id']) ? $_GET['order_id'] : '';
    $signature = isset($_GET['signature']) ? $_GET['signature'] : '';
    
    try {
        // Initialize Razorpay API with credentials from config
        $api = new Api(RAZORPAY_KEY_ID, RAZORPAY_KEY_SECRET);
        
        // Verify payment signature first
        $payment_status = verifyRazorpayPayment([
            'razorpay_payment_id' => $payment_id,
            'razorpay_order_id' => $order_id,
            'razorpay_signature' => $signature
        ]);
        
        // Additional verification - check payment status with Razorpay API
        $payment = $api->payment->fetch($payment_id);
        
        if($payment_status && $payment->status === 'captured') {
            $status = 'Complete';
        } else {
            $status = 'Failed';
            error_log("Payment verification failed for $payment_id. Status: ".$payment->status);
        }
    } catch (Exception $e) {
        $status = 'Failed';
        error_log("Payment processing error: " . $e->getMessage());
    }
} else {
    $status = $payment_method === 'COD' ? 'Pending' : 'Failed';
    $payment_id = $payment_method === 'COD' ? 'COD' : '';
}

// Getting product price and quantity of items
$ip_add = getRealIpAddr();
$total = 0;
$sel_price = "SELECT * FROM cart WHERE ip_add='$ip_add'";
$run_price = mysqli_query($con, $sel_price);

if(!$run_price) {
    die("Query failed: " . mysqli_error($con));
}

$invoice_no = mt_rand(1,1000);
$i = 0;
$count_pro = mysqli_num_rows($run_price);

while($record = mysqli_fetch_array($run_price)){
  $pro_id = $record['p_id'];

  $pro_price = "SELECT * FROM products WHERE product_id='$pro_id'";
  $run_pro_price = mysqli_query($con, $pro_price);

  while($p_price = mysqli_fetch_array($run_pro_price)){
    $product_name = $p_price['product_title'];
    $product_price = array($p_price['product_price']);
    $values = array_sum($product_price);
    $total = $total + $values;
    $i++;
  }
}

// Getting Quantity from the Cart
$get_cart = "SELECT * FROM cart";
$run_cart = mysqli_query($con, $get_cart);
$get_qty = mysqli_fetch_array($run_cart);
$qty = $get_qty['qty'];
if($qty == 0) {
  $qty = 1;
  $sub_total = $total;
} else {
  $qty = $qty;
  $sub_total = $total * $qty;
}

$product_names = []; // Initialize an array to collect product titles

$sel_price = "SELECT * FROM cart WHERE ip_add='$ip_add'";
$run_price = mysqli_query($con, $sel_price);
$count_pro = mysqli_num_rows($run_price);
$total = 0;
$i = 0;

while($record = mysqli_fetch_array($run_price)){
    $pro_id = $record['p_id'];

    $pro_price = "SELECT * FROM products WHERE product_id='$pro_id'";
    $run_pro_price = mysqli_query($con, $pro_price);

    while($p_price = mysqli_fetch_array($run_pro_price)){
        $product_name = $p_price['product_title'];
        $product_price = $p_price['product_price'];

        $product_names[] = $product_name; // Collect product title

        $total += $product_price;
        $i++;
    }
}

$product_names_str = implode(", ", $product_names); // Convert array to comma-separated string


$insert_order = "INSERT INTO customer_orders 
                (customer_id, due_amount, invoice_no, total_products, order_date, order_status, payment_method, payment_id, product_names) 
                VALUES 
                ('$customer_id', '$sub_total', '$invoice_no', '$count_pro', NOW(), '$status', '$payment_method', '$payment_id', '$product_names_str')";

$run_order = mysqli_query($con, $insert_order);
$product_names = []; // Initialize an array to collect product titles


if(!$run_order) {
    die("Order creation failed: " . mysqli_error($con));
}

$empty_cart = "DELETE FROM cart WHERE ip_add='$ip_add'";
$run_empty = mysqli_query($con, $empty_cart);

$insert_to_pending_orders = "INSERT INTO pending_order (customer_id, invoice_no, product_id, qty, order_status) 
                           VALUES ('$customer_id', '$invoice_no', '$pro_id', '$qty', '$status')";
$run_pending_order = mysqli_query($con, $insert_to_pending_orders);

// Email sending code remains the same...

  $from="admin@mysite.com";
  $subject="Order Details";
  $message="
    <html>
    <p>Hello $customer_name, You have ordered following products on our website, Please find your order details below and pay the dues as soon as possible.</p>
      <table width='600' align='center' bgcolor='#E3A587' border='2'>
        <tr><td><h2>Your order Details from mysite.com</h2></td></tr>
        <tr>
          <th><b>S.N</b></th>
          <th><b>Product Name</b></th>
          <th><b>Quantity</b></th>
          <th><b>Total Price</b></th>
          <th><b>Invoice No.</b></th>
          <th><b>Payment Status</b></th>
        </tr>
        <tr>
          <td>$i</td>
          <td>$product_name</td>
          <td>$qty</td>
          <td>$sub_total</td>
          <td>$invoice_no</td>
          <td>$status</td>
        </tr>
      </table>
      <h3>Please go to your account and pay the dues.</h3>
      <h2><a href='mysite.com'>Click here</a> to login to yout account.</h2>
      <h3>Thank you for ordering on www.mysite.com</h3>
    </html



  ";
  mail($customer_email,$subject,$message,$from);
  echo "<script>alert('Your order has been placed successfully. Your order details have been sent to $customer_email.')</script>";
  echo "<script>window.open('customer/my_account.php','_self')</script>";
 ?>
