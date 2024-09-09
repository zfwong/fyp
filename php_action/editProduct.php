<?php

require_once 'core.php';

$valid['success'] = array('success' => false, 'messages' => array());

if ($_POST) {
	$productId = $_POST['productId'];
	$productName = $_POST['editProductName'];
	$cost = $_POST['editcostperunit'];
	$quantity = $_POST['editQuantity'];
	$supplier = $_POST['editSupplier'];
	$brandName = $_POST['editBrandName'];	
	$categoryName = $_POST['editCategoryName'];
	$productStatus = $_POST['editProductStatus'];

	$sql = "UPDATE product SET product_name = '$productName', product_cost = '$cost', brand_id = '$brandName', categories_id = '$categoryName', quantity = '$quantity', supplier_id = '$supplier', active = '$productStatus', status = 1 WHERE product_id = $productId";

	if($connect->query($sql) === TRUE) {
		$valid['success'] = true;
		$valid['messages'] = '&nbsp;&nbsp;Successfully Updated';
	} else {
		$valid['success'] = false;
		$valid['messages'] = '&nbsp;&nbsp;Error while updating the product information';
	}
}// /if $_POST

$connect->close();

echo json_encode($valid);