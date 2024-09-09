<?php

require_once 'core.php';

$valid['success'] = array('success' => false, 'messages' => array());

if ($_POST) {
	$suppName = $_POST['editSupplierName'];
	$suppPerson = $_POST['editSupplierPerson'];
	$suppContact = $_POST['editSupplierContact'];
	$suppStatus = $_POST['editSupplierStatus'];
	$suppMail = $_POST['editSupplierMail'];
	$suppAddress = $_POST['editSupplierAddress'];
	$supplierId = $_POST['supplierId'];

	$sql = "UPDATE supplier SET supplier_name = '$suppName', contact_person = '$suppPerson', supplier_address = '$suppAddress', supplier_contact = '$suppContact', supplier_email = '$suppMail', supplier_active = '$suppStatus' WHERE supplier_id = '$supplierId'";

	if ($connect->query($sql) === TRUE) {
		$valid['success'] = true;
		$valid['messages'] = '&nbsp;&nbsp;Successfully Updated';
	} else {
		$valid['success'] = false;
		$valid['messages'] = '&nbsp;&nbsp;Error while updating the brand';
	}

	$connect->close();

	echo json_encode($valid);
}