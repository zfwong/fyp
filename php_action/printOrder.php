<?php

require_once 'core.php';

$orderId = $_POST['orderId'];

$sql = "SELECT orders.order_date, orders.supplier_id, orders.supplier_contact, orders.sub_total, orders.gst, orders.grand_total, orders.paid, orders.due, supplier.supplier_name, orders.payment_method FROM orders 
INNER JOIN supplier ON orders.supplier_id = supplier.supplier_id 
WHERE order_id = '$orderId'";

$orderResult = $connect->query($sql);
$orderData = $orderResult->fetch_array();

$orderDate = date('d-m-Y', strtotime($orderData[0]));
$supplierName = $orderData[8];
$supplierContact = $orderData[2];
$subTotal = $orderData[3];
$gst = $orderData[4];
$grandTotal = $orderData[5];
$paidAmount = $orderData[6];
$dueAmount = $orderData[7];
$paymentMethod = $orderData[9];

$orderItemSql = "SELECT orders_items.product_id, orders_items.quantity, orders_items.cost, orders_items.total, product.product_name FROM orders_items 
INNER JOIN product ON orders_items.product_id = product.product_id 
WHERE orders_items.order_id = '$orderId'";

$orderItemResult = $connect->query($orderItemSql);

$table = 
'<div style="border:1px solid;padding:20px 10px;">

	Order Date : '.$orderDate.'<br />
	Supplier : '.$supplierName.'<br />
	Contact : '.$supplierContact.'<br />
	Payment Method : ';

	if ($paymentMethod == "1") {
		$table .= 'Cash';
	} else if ($paymentMethod == "2") {
		$table .= 'Cheque';
	} else if ($paymentMethod == "3") {
		$table .= 'Credit Card';
	}

$table .= 
	'<br />
	<br />
	<hr />

	<table border="0" width="100%" cellpadding="5">
		<tbody>
			<tr>
				<th>No.</th>
				<th>Product</th>
				<th>Cost/Unit (RM)</th>
				<th>Quantity</th>
				<th>Total (RM)</th>
			</tr>';

			$n = 1;
			while ($productRow = $orderItemResult->fetch_array()) {
				$productName = $productRow[4];
				$quantity = $productRow[1];
				$cost = $productRow[2];
				$total = $productRow[3];


				$table .= 
			'<tr style="text-align:center;">
				<td>'.$n.'</td>
				<td>'.$productName.'</td>
				<td>'.$cost.'</td>
				<td>'.$quantity.'</td>
				<td>'.$total.'</td>
			</tr>';
				$n++;
			}

$table .= 
		'</tbody>
	</table>
	<hr />

	<table border="0" width="100%" style="border-collapse:collapse;">
		<tr>
			<td rowspan="6" width="65%"></td>
		</tr>
		<tr>
			<td align="right">SubTotal : </td>
			<td align="center" width="15%">'.$subTotal.'</td>
		</tr>
		<tr style="border-bottom:1px solid;">
			<td align="right">GST 6% : </td>
			<td align="center">'.$gst.'</td>
		</tr>
		<tr>
			<td align="right">Grand Total : </td>
			<td align="center"><b>'.$grandTotal.'</b></td>
		</tr>
		<tr style="border-bottom:1px solid;">
			<td align="right">Paid Amount (RM) : </td>
			<td align="center">'.$paidAmount.'</td>
		</tr>
		<tr>
			<td align="right">Due Amount (RM) : </td>
			<td align="center"><b>'.$dueAmount.'</b></td>
		</tr>
	</table>

	<hr />
</div>';

$connect->close();

echo $table;