<?php
require_once('tcpdf/tcpdf.php');
include('../includes/db.php');

if (isset($_GET['order_id'])) {
    $order_id = intval($_GET['order_id']);

    // Fetch order details
$query = "SELECT co.order_id, co.order_date, co.due_amount AS total_amount,
                 co.product_names,
                 c.customer_name AS name, c.customer_email AS email,
                 c.customer_contact AS phone, c.customer_address AS address
          FROM customer_orders co
          JOIN customers c ON co.customer_id = c.customer_id
          WHERE co.order_id = ?";

    $stmt = $con->prepare($query);
    if (!$stmt) {
        die("Prepare failed: " . $con->error);
    }

    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $order = $result->fetch_assoc();

    if (!$order) {
        die('Order not found.');
    }

    // Generate PDF with enhanced styling
    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
    
    // Set document information
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('FURNIORA');
    $pdf->SetTitle('Invoice #' . $order['order_id']);
    $pdf->SetSubject('Invoice');
    
    // Set margins
    $pdf->SetMargins(15, 25, 15);
    $pdf->SetHeaderMargin(10);
    $pdf->SetFooterMargin(10);
    
    // Add a page
    $pdf->AddPage();
    
    // Set font
    $pdf->SetFont('helvetica', '', 10);

    // HTML content with CSS styling
    // HTML content with updated CSS for the table
$html = '
<style>
    .header {
        color: #2c3e50;
        text-align: center;
        margin-bottom: 20px;
    }
    .company-info {
        background-color: #f8f9fa;
        padding: 15px;
        border-radius: 5px;
        margin-bottom: 20px;
    }
    .invoice-title {
        color: #3498db;
        font-size: 24px;
        font-weight: bold;
        margin-bottom: 10px;
    }
    .invoice-details {
        background-color: #e8f4fc;
        padding: 15px;
        border-radius: 5px;
        margin-bottom: 20px;
    }
    .customer-info {
        background-color: #f1f8e9;
        padding: 15px;
        border-radius: 5px;
        margin-bottom: 20px;
    }
    .table-header {
        background-color: #3498db;
        color: #ffffff;
        font-weight: bold;
        text-align: left;
        padding: 8px;
    }
    .table-row {
        border-bottom: 1px solid #dddddd;
        text-align: left;
    }
    .table-cell {
        padding: 8px;
    }
    .table-row td {
        vertical-align: middle;
    }
    .total-amount {
        background-color: #f8f9fa;
        padding: 10px;
        font-weight: bold;
        text-align: right;
        font-size: 16px;
        margin-top: 10px;
    }
    .footer {
        text-align: center;
        margin-top: 30px;
        color: #7f8c8d;
        font-size: 10px;
    }
</style>

<div class="header">
    <h1 style="color: #2c3e50;">FURNIORA</h1>
    <p style="font-size:12px;">FURNIORA, 121, akurdi railway station, PCMC, Pune | Phone: 9928885627</p>
    <p style="font-size:12px;">Email: FURNIORA@gmail.com</p>
</div>

<div class="invoice-title">INVOICE</div>

<div style="display: flex; justify-content: space-between; margin-bottom: 20px;">
    <div class="invoice-details" style="width: 48%;">
        <h3 style="color: #3498db; margin-top: 0;">Invoice Details</h3>
        <p><strong>Invoice #:</strong> ' . $order['order_id'] . '</p>
        <p><strong>Date:</strong> ' . date('F j, Y', strtotime($order['order_date'])) . '</p>
        <p><strong>Due Date:</strong> ' . date('F j, Y', strtotime($order['order_date'] . ' + 15 days')) . '</p>
    </div>

    <div class="customer-info" style="width: 48%;">
        <h3 style="color: #2ecc71; margin-top: 0;">Customer Details</h3>
        <p><strong>Name:</strong> ' . $order['name'] . '</p>
        <p><strong>Email:</strong> ' . $order['email'] . '</p>
        <p><strong>Phone:</strong> ' . ($order['phone'] ?? 'N/A') . '</p>
        <p><strong>Address:</strong> ' . ($order['address'] ?? 'N/A') . '</p>
    </div>
</div>

<table width="95%" cellspacing="0" cellpadding="5">
    <tr class="table-header">
        <td width="10%" class="table-cell"><strong>Item</strong></td>
        <td width="50%" class="table-cell"><strong>Description</strong></td>
        <td width="15%" align="right" class="table-cell"><strong>Quantity</strong></td>
        <td width="15%" align="right" class="table-cell"><strong>Unit Price</strong></td>
        <td width="20%" align="right" class="table-cell"><strong>Amount</strong></td>
    </tr>
    <tr class="table-row">
        <td class="table-cell">1</td>
        <td class="table-cell">' . htmlspecialchars($order['product_names']) . '</td>
        <td align="right" class="table-cell">1</td>
        <td align="right" class="table-cell">Rs.' . number_format($order['total_amount'], 2) . '</td>
        <td align="right" class="table-cell">Rs.' . number_format($order['total_amount'], 2) . '</td>
    </tr>
</table>

<div class="total-amount">
    <strong>TOTAL: Rs.' . number_format($order['total_amount'], 2) . '</strong>
</div>

<div class="footer">
    <p>Thank you for your business!</p>
    <p>Terms & Conditions: Payment is due within 15 days. Please make checks payable to Your Company Name.</p>
    <p>This is a computer generated invoice and does not require a signature.</p>
</div>';


    // Output HTML content
    $pdf->writeHTML($html, true, false, true, false, '');
    
    // Add a border around the entire page
    $pdf->Rect(5, 5, $pdf->getPageWidth() - 10, $pdf->getPageHeight() - 10);
    
    // Close and output PDF document
    $pdf->Output("invoice_{$order_id}.pdf", 'D');
} else {
    echo "Order ID not provided.";
}
?>