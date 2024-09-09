<?php

require_once 'core.php';

$valid['success'] = array('success' => false, 'messages' => array());

$orderId = $_POST['orderId'];

if ($orderId) {
	$orderSql = "UPDATE orders SET  order_status = 2 WHERE order_id = {$orderId}";
	$orderItemSql = "UPDATE orders_items SET orders_item_status = 2 WHERE order_id = {$orderId}";

	if ($connect->query($orderSql) === TRUE && $connect->query($orderItemSql) === TRUE) {
		$valid['success'] = true;
		$valid['messages'] = '&nbsp;&nbsp;Successfully Removed';
	} else {
		$valid['success'] = false;
		$valid['messages'] = '&nbsp;&nbsp;Error while removing the order';		
	}

	$connect->close();

	echo json_encode($valid);
}