<?php

require_once 'core.php';

$valid['success'] = array('success' => false, 'messages' => array());

$supplierId = $_POST['supplierId'];

if ($supplierId) {
	$sql = "UPDATE supplier SET supplier_status = 2 WHERE supplier_id = {$supplierId}";

	if ($connect->query($sql) === TRUE) {
		$valid['success'] = true;
		$valid['messages'] = "&nbsp;&nbsp;Successfully Removed";
	} else {
		$valid['success'] = false;
		$valid['messages'] = "&nbsp;&nbsp;Error while removing supplier";
	}

	$connect->close();

	echo json_encode($valid);
}

?>