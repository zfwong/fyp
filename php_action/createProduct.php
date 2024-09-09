<?php

require_once 'core.php';

$valid['success'] = array('success' => false, 'messages' => array());

if ($_POST) {
	$productName = $_POST['productName'];
	$quantity = $_POST['quantity'];
	$supplier = $_POST['supplier'];
	$cost = $_POST['costperunit'];
	$brandName = $_POST['brandName'];
	$categoryName = $_POST['categoryName'];
	$productStatus = $_POST['productStatus'];

	// for product image
	$type = explode('.', $_FILES['productImage']['name']);
	$type = $type[count($type) - 1];
	$url = '../assets/images/stock/'.uniqid(rand()).'.'.$type;

	// echo $url;

	if (in_array($type, array('gif', 'jpg', 'jpeg', 'png', 'JPG', 'GIF', 'JPEG', 'PNG'))) {
		if (is_uploaded_file($_FILES['productImage']['tmp_name'])) {
			if (move_uploaded_file($_FILES['productImage']['tmp_name'], $url)) {

				// insert into the database
				$sql = "INSERT INTO product (product_name, product_image, product_cost, brand_id, categories_id, quantity, supplier_id, active, status) VALUES ('$productName', '$url', '$cost','$brandName', '$categoryName', '$quantity', '$supplier', '$productStatus', 1)";

				if ($connect->query($sql) === TRUE) {
					$valid['success'] = true;
					$valid['messages'] = "&nbsp;&nbsp;Successfully Added";
				} else {
					$valid['success'] = false;
					$valid['messages'] = "&nbsp;&nbsp;Error while adding the product";
				}

				
			} else {
				return false;
			}
		}// if is_uploaded_file
	}// /if in_array

	// close database connection
	$connect->close();

	echo json_encode($valid);
}// /if $_POST