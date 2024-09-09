<?php

require_once 'core.php';

$sql = "SELECT supplier_id, supplier_name, contact_person, supplier_address, supplier_contact, supplier_email, supplier_active, supplier_status FROM supplier WHERE supplier_status = 1";

$result = $connect->query($sql);

$output = array('data' => array());

if ($result->num_rows > 0) {
	while ($row = $result->fetch_array()) {
		$supplierId = $row[0];
		$supplierAddr = str_replace(array("\r\n", "\r", "\n"), "<br />", $row[3]);

		// active
		if($row[6] == 1) {
			// active member
			$activeBrands = "<label class='label label-success'>Available</label>";
		} else {
			// deactive member
			$activeBrands = "<label class='label label-danger'>Not Available</label>";
		}

		$button = '<!-- Single button -->
		<span class="dropdown">
			<div class="btn-group">
			  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			    Action <span class="caret"></span>
			  </button>
			  <ul class="dropdown-menu">
			    <li><a href="button" data-toggle="modal" data-target="#editSupplierModal" onclick="editSupplier('.$supplierId.')"><i class="glyphicon glyphicon-edit"></i>&nbsp;&nbsp;Edit</a></li>
			    <li><a href="button" data-toggle="modal" data-target="#removeSupplierModal" onclick="removeSupplier('.$supplierId.')"><i class="glyphicon glyphicon-trash"></i>&nbsp;&nbsp;Remove</a></li>
			  </ul>
			</div>
		</span>';
		
		$output['data'][] = array(
			$row[1],
			$row[2],
			$supplierAddr,
			$row[4],
			$row[5],
			$activeBrands,
			$button
		);	
	}// /while
}// /if

$connect->close();

echo json_encode($output);