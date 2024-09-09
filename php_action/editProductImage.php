<?php

require_once 'core.php';

$valid['success'] = array('success' => false, 'messages' => array());

if ($_POST) {
	$productId = $_POST['productId'];

	$type = explode('.', $_FILES['editProductImage']['name']);
	$type = $type[count($type) - 1];
	$url = '../assets/images/stock/'.uniqid(rand()).'.'.$type;

	// echo $url;

	if (in_array($type, array('gif', 'jpg', 'jpeg', 'png', 'JPG', 'GIF', 'JPEG', 'PNG'))) {
		if (is_uploaded_file($_FILES['editProductImage']['tmp_name'])) {
			if (move_uploaded_file($_FILES['editProductImage']['tmp_name'], $url)) {

				// insert into the database
				$sql = "UPDATE product SET product_image = '$url' WHERE product_id = $productId";

				if ($connect->query($sql) === TRUE) {
					$valid['success'] = true;
					$valid['messages'] = "&nbsp;&nbsp;Successfully Added";
				} else {
					$valid['success'] = false;
					$valid['messages'] = "&nbsp;&nbsp;Error while adding the product";
				}

				
			} else {
				return false;
			}// /else
		}// /if is_uploaded_file
	}// /if in_array

	$connect->close();

	echo json_encode($valid);
}// /if $_POST
