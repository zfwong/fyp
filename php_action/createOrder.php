<?php

require_once 'core.php';

$valid['success'] = array('success' => false, 'messages' => array(), 'order_id' => '');

if ($_POST) {
	$orderDate = date('Y-m-d', strtotime($_POST['orderDate']));
	$orderSupplier = $_POST['orderSupplier'];
	$orderContact = $_POST['orderContact'];
	$subTotal = $_POST['subTotalValue'];
	$gst = $_POST['gstValue'];
	$grandTotal = $_POST['grandTotalValue'];
	$paidAmount = $_POST['paid'];
	$dueAmount = $_POST['dueValue'];
	$paymentMethod = $_POST['paymentMethod'];

	$sql = "INSERT INTO orders (order_date, supplier_id, supplier_contact, sub_total, gst, grand_total, paid, due, payment_method, order_active, order_status) VALUES ('$orderDate', '$orderSupplier', '$orderContact', '$subTotal', '$gst', '$grandTotal', '$paidAmount', '$dueAmount', '$paymentMethod', 2, 1)";

	$order_id;
	$orderStatus = false;
	if ($connect->query($sql) === TRUE) {
		$order_id = $connect->insert_id;
		$valid['order_id'] = $order_id;

		$orderStatus = true;
	}

	$orderItemStatus = false;

	for ($x = 0; $x < count($_POST['productName']); $x++) {
		$orderItemSql = "INSERT INTO orders_items (order_id, product_id, quantity, cost, total, orders_item_status) VALUES ('$order_id', '".$_POST['productName'][$x]."', '".$_POST['productQty'][$x]."', '".$_POST['productCostValue'][$x]."', '".$_POST['productTotalValue'][$x]."', 1)";

		$connect->query($orderItemSql);

		if ($x == count($_POST['productName'])) {
			$orderItemStatus = true;
		}
	}

	$valid['success'] = true;
	$valid['messages'] = '&nbsp;&nbsp;Successfully Added';

	$connect->close();

	echo json_encode($valid);
}