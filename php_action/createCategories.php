<?php

require_once 'core.php';

$valid['success'] = array('success' => false, 'messages' => array());

if ($_POST) {
	$categoriesName = $_POST['categoriesName'];
	$categoriesStatus = $_POST['categoriesStatus'];

	$sql = "INSERT INTO category (categories_name, categories_active, categories_status) VALUES ('$categoriesName', '$categoriesStatus', 1)";

	if ($connect->query($sql) === TRUE) {
		$valid['success'] = true;
		$valid['messages'] = '&nbsp;&nbsp;Successfully Added';
	} else {
		$valid['success'] = false;
		$valid['messages'] = '&nbsp;&nbsp;Error while adding the categories';
	}

	$connect->close();

	echo json_encode($valid);
}// /if $_POST