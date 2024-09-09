<?php

require_once 'core.php';

$valid['success'] = array('success' => false, 'messages' => array());

if ($_POST){
	$suppName = $_POST['supplierName'];
	$suppPerson = $_POST['supplierPerson'];
	$suppAddress = $_POST['supplierAddress'];
	$suppContact = $_POST['supplierContact'];
	$suppMail = $_POST['supplierMail'];
	$suppStatus = $_POST['supplierStatus'];

	$sql = "INSERT INTO supplier (supplier_name, contact_person, supplier_address, supplier_contact, supplier_email, supplier_active, supplier_status) VALUES ('$suppName', '$suppPerson', '$suppAddress', '$suppContact', '$suppMail', '$suppStatus', 1)";

	if ($connect->query($sql) === TRUE) {
		$valid['success'] = true;
		$valid['messages'] = '&nbsp;&nbsp;Successfully Added';
	} else {
		$valid['success'] = false;
		$valid['messages'] = '&nbsp;&nbsp;Error while adding the supplier';
	}

	$connect->close();

	echo json_encode($valid);

}