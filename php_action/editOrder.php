<?php

require_once 'core.php';

$valid['success'] = array('success' => false, 'messages' => array());

if ($_POST) {
	$orderId = $_POST['orderId'];
	$orderDate = date('Y-m-d', strtotime($_POST['orderDate']));
	$orderSupplier = $_POST['orderSupplier'];
	$orderContact = $_POST['orderContact'];
	$subTotal = $_POST['subTotalValue'];
	$gst = $_POST['gstValue'];
	$grandTotal = $_POST['grandTotalValue'];
	$paidAmount = $_POST['paid'];
	$dueAmount = $_POST['dueValue'];
	$paymentMethod = $_POST['paymentMethod'];
	$orderStatus = $_POST['orderStatus'];

	$sql = "UPDATE orders SET order_date = '$orderDate', supplier_id = '$orderSupplier', supplier_contact = '$orderContact', sub_total = '$subTotal', gst = '$gst', grand_total = '$grandTotal', paid = '$paidAmount', due = '$dueAmount', payment_method = '$paymentMethod', order_active = '$orderStatus', order_status = 1 WHERE order_id = {$orderId}";

	$connect->query($sql);

	$removeOrderItemSql = "DELETE FROM orders_items WHERE order_id = {$orderId}";
	$connect->query($removeOrderItemSql);

	for ($x = 0; $x < count($_POST['productName']); $x++) { 
		$orderItemSql = "INSERT INTO orders_items (order_id, product_id, quantity, cost, total, orders_item_status) VALUES ({$orderId}, '".$_POST['productName'][$x]."', '".$_POST['productQty'][$x]."', '".$_POST['productCostValue'][$x]."', '".$_POST['productTotalValue'][$x]."', 1)";
		$connect->query($orderItemSql);
	}
	

	$valid['success'] = true;
	$valid['messages'] = '&nbsp;&nbsp;Successfully Updated';

	$connect->close();

	echo json_encode($valid);
}