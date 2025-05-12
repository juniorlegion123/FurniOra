<?php
include("includes/db.php");

// Debug session
echo "<!-- DEBUG: Session email: ".(isset($_SESSION['customer_email']) ? $_SESSION['customer_email'] : 'NOT SET')." -->";

// Getting the customer Id
if(isset($_SESSION['customer_email'])) {
    $c = $_SESSION['customer_email'];
    $get_c = "SELECT * FROM customers WHERE customer_email='$c'";
    $run_c = mysqli_query($con, $get_c);
    
    if(!$run_c) {
        die("Query failed: ".mysqli_error($con));
    }
    
    if(mysqli_num_rows($run_c) > 0) {
        $row_c = mysqli_fetch_array($run_c);
        $customer_id = $row_c['customer_id'];
        echo "<!-- DEBUG: Logged in as customer ID: $customer_id -->";
        
        // Verify customer exists
        $verify = "SELECT COUNT(*) as count FROM customers WHERE customer_id='$customer_id'";
        $run_verify = mysqli_query($con, $verify);
        $verify_data = mysqli_fetch_assoc($run_verify);
        echo "<!-- DEBUG: Customer exists? ".$verify_data['count']." -->";
    } else {
        die("Customer not found");
    }
} else {
    die("Please login to view orders");
}

// Debug - check if any orders exist in system
$any_orders = "SELECT COUNT(*) as total FROM customer_orders";
$run_any = mysqli_query($con, $any_orders);
$any_data = mysqli_fetch_assoc($run_any);
echo "<!-- DEBUG: Total orders in system: ".$any_data['total']." -->";

// Debug - check orders for this customer
$check_orders = "SELECT COUNT(*) as count FROM customer_orders WHERE customer_id='$customer_id'";
$run_check = mysqli_query($con, $check_orders);
if(!$run_check) {
    echo "<!-- DEBUG: Count query failed: ".mysqli_error($con)." -->";
} else {
    $row_check = mysqli_fetch_assoc($run_check);
    echo "<!-- DEBUG: Found ".$row_check['count']." orders for customer $customer_id -->";
}
?>

<h1><center>All Order Details</center></h1>
<table width="750" align="center" border="1px solid black;">
  <tr>
    <th>Order No.</th>
    <th>Due Amount</th>
    <th>Invoice No.</th>
    <th>Total products</th>
    <th>Order Date</th>
    <th>Payment Status</th>
    <th>Download Invoice</th>
  </tr>
  <?php
    $get_orders = "SELECT * FROM customer_orders WHERE customer_id='$customer_id' ORDER BY order_date DESC";
    echo "<!-- DEBUG: Query = $get_orders -->";
    $run_orders = mysqli_query($con, $get_orders);
    
    if(!$run_orders) {
        echo "<tr><td colspan='7'>Error: ".mysqli_error($con)."</td></tr>";
    } elseif(mysqli_num_rows($run_orders) == 0) {
        echo "<tr><td colspan='7'>No orders found for customer ID: $customer_id</td></tr>";
    } else {
        $i = 0;
while ($row = mysqli_fetch_array($run_orders)) {
    $order_id = $row['order_id'];
    $due_amount = $row['due_amount'];
    $invoice_no = $row['invoice_no'];
    $products = $row['total_products'];
    $date = $row['order_date'];
    $payment_status = $row['order_status'];

    $i++;

    echo "
      <tr align='center'>
        <td>$i</td>
        <td>$due_amount</td>
        <td>$invoice_no</td>
        <td>$products</td>
        <td>$date</td>
        <td>$payment_status</td>
        <td>
          <a href='generate_invoice.php?order_id=$order_id' target='_blank' class='btn btn-sm btn-primary'>Download</a>
        </td>
      </tr>
    ";
}
    }
  ?>
</table>