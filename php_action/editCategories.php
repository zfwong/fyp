<?php

require_once 'core.php';

$valid['success'] = array('success' => false, 'messages' => array());

if ($_POST) {
	$categoriesName = $_POST['editcategoriesName'];
	$categoriesStatus = $_POST['editcategoriesStatus'];
	$categoriesId = $_POST['editCategoriesId'];

	$sql = "UPDATE category SET categories_name = '$categoriesName', categories_active = '$categoriesStatus' WHERE categories_id = '$categoriesId'";

	if ($connect->query($sql) === TRUE) {
		$valid['success'] = true;
		$valid['messages'] = '&nbsp;&nbsp;Successfully Updated';
	} else {
		$valid['success'] = false;
		$valid['messages'] = '&nbsp;&nbsp;Error while updating the categories';
	}

	$connect->close();

	echo json_encode($valid);
}// /if $_POST