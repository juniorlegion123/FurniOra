<!DOCTYPE html>
<html>
<head>
    <title>Payment Options</title>
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
</head>
<body>
<?php
include("includes/db.php");
include("includes/razorpay-config.php");

// Get customer ID from session
if(isset($_SESSION['customer_email'])) {
    $customer_email = $_SESSION['customer_email'];
    $get_customer = "SELECT * FROM customers WHERE customer_email='$customer_email'";
    $run_customer = mysqli_query($con, $get_customer);
    
    if(!$run_customer) {
        die("Database error: " . mysqli_error($con));
    }
    
    $customer = mysqli_fetch_array($run_customer);
    if(!$customer) {
        die("Customer not found");
    }
    $customer_id = $customer['customer_id'];
} else {
    die("Customer not logged in");
}

// Get cart total amount
$total = 0;
$ip = getRealIpAddr();
$sel_price = "SELECT * FROM cart WHERE ip_add='$ip'";
$run_price = mysqli_query($con, $sel_price);

if(!$run_price) {
    die("Cart query failed: " . mysqli_error($con));
}

while($record = mysqli_fetch_array($run_price)) {
    $pro_id = $record['p_id'];
    $pro_qty = $record['qty'];
    $sub_query = "SELECT * FROM products WHERE product_id='$pro_id'";
    $run_sub_query = mysqli_query($con, $sub_query);
    
    if(!$run_sub_query) {
        die("Product query failed: " . mysqli_error($con));
    }
    
    while($sub_record = mysqli_fetch_array($run_sub_query)) {
        $product_price = $sub_record['product_price'];
        $total += $product_price * $pro_qty;
    }
}
?>

<div align="center" style="padding:0px;width: 120%;">
  <h2>Payment Options</h2><hr>
  <b>Pay with:</b><br>
  
  <!-- Razorpay Option -->
  <button id="rzp-button" style="background: #528FF0; color: white; border: none; padding: 10px 20px; border-radius: 4px; cursor: pointer; font-size: 16px; margin: 10px;">
    Pay with Razorpay
  </button>
  
  <script>
    document.getElementById('rzp-button').onclick = function(e) {
      var options = {
        "key": "<?php echo RAZORPAY_KEY_ID; ?>", // Use constant from config
        "amount": "<?php echo $total * 100; ?>", 
        "currency": "INR",
        "name": "Furniture House",
        "description": "Order Payment",
        "order_id": "",
        "handler": function(response) {
          if(response.razorpay_payment_id) {
            window.location.href = "order.php?c_id=<?php echo $customer_id; ?>" + 
                                 "&payment_id=" + response.razorpay_payment_id +
                                 "&order_id=" + response.razorpay_order_id +
                                 "&signature=" + response.razorpay_signature +
                                 "&payment_method=Razorpay";
          } else {
            alert('Payment failed - no payment ID received');
          }
        },
        "prefill": {
          "name": "<?php echo htmlspecialchars($customer['customer_name']); ?>",
          "email": "<?php echo htmlspecialchars($customer['customer_email']); ?>"
        },
        "theme": {
          "color": "#528FF0"
        }
      };
      
      // Create order first
      fetch('create-razorpay-order.php?amount=<?php echo $total; ?>&customer_id=<?php echo $customer_id; ?>')
        .then(response => {
          if(!response.ok) {
            throw new Error('Network response was not ok');
          }
          return response.json();
        })
        .then(data => {
          if(data.error) {
            throw new Error(data.error);
          }
          options.order_id = data.id;
          var rzp = new Razorpay(options);
          rzp.open();
        })
        .catch(error => {
          console.error('Error:', error);
          alert('Failed to create payment order: ' + error.message);
        });
    }
  </script>
  
  <!-- COD Option -->
  <b><br>Or <a href="order.php?c_id=<?php echo $customer_id; ?>&payment_method=COD">Cash On Delivery</a></b>
  <br>
  <b>If you selected Cash On Delivery, please check your email or account for the Invoice No.</b>
</div>
</body>
</html>