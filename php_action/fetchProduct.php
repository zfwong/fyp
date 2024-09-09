<?php 

require_once 'core.php';

$sql = "SELECT product.product_id, product.product_name, product.product_image, product.product_cost, product.brand_id, product.categories_id, product.quantity, product.supplier_id, product.active, product.status, brands.brand_name, category.categories_name, supplier.supplier_name FROM product 
	INNER JOIN brands ON product.brand_id = brands.brand_id 
	INNER JOIN category ON product.categories_id = category.categories_id
	INNER JOIN supplier ON product.supplier_id = supplier.supplier_id
	WHERE product.status = 1";

$result = $connect->query($sql);

$output = array('data' => array());

if ($result->num_rows > 0) {
	$active = "";

	while ($row = $result->fetch_array()) {
		// product id
		$productId = $row[0];
		// active
		if ($row[8] == 1) {
			$active = "<label class='label label-success'>Available</label>";	
		} else {
			$active = "<label class='label label-danger'>Not Available</label>";
		}

		$button = '<!-- Single button -->
		<div class="btn-group">
		  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		    Action <span class="caret"></span>
		  </button>
		  <ul class="dropdown-menu">
		    <li><a href="button" data-toggle="modal" data-target="#editProductModal" onclick="editProduct('.$productId.')"><i class="glyphicon glyphicon-edit"></i>&nbsp;&nbsp;Edit</a></li>
		    <li><a href="button" data-toggle="modal" data-target="#removeProductModal" onclick="removeProduct('.$productId.')"><i class="glyphicon glyphicon-trash"></i>&nbsp;&nbsp;Remove</a></li>
		  </ul>
		</div>';

		$cost = $row[3];
		$brand = $row[10];
		$category = $row[11];
		$supplier = $row[12];
		$quantity = $row[6];
		$productName = $row[1];

		$imageUrl = substr($row[2],3);
		$productImage = "<img class='img-round' src='".$imageUrl."' style='height: 30px;width: 50px;' />";

		$output['data'][] = array(
			$productImage,
			$productName,
			$supplier,
			$cost,
			$quantity,
			$brand,
			$category,
			$active,
			$button
		);
	}// /while
}// /if

$connect->close();

echo json_encode($output);