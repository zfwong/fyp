<?php 

require_once 'core.php';

$valid['success'] = array('success' => false, 'messages' => array());

if ($_POST) {
	$brandName = $_POST['editBrandName'];
	$brandStatus = $_POST['editBrandStatus'];
	$brandId = $_POST['brandId'];

	$sql = "UPDATE brands SET brand_name = '$brandName', brand_active = '$brandStatus' WHERE brand_id = '$brandId'";

	if ($connect->query($sql) === TRUE) {
		$valid['success'] = true;
		$valid['messages'] = "&nbsp;&nbsp;Successfully Updated";
	} else {
		$valid['success'] = false;
		$valid['messages'] = "&nbsp;&nbsp;Error while updating the brand";
	}

	$connect->close();

	echo json_encode($valid);
}