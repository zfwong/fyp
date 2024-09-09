<?php

require_once 'core.php';

$sql = "SELECT orders.order_id, orders.supplier_id, orders.order_date, orders.supplier_contact, supplier.supplier_name, orders.order_active FROM orders 
INNER JOIN supplier ON orders.supplier_id = supplier.supplier_id 
WHERE orders.order_status = 1";

$result = $connect->query($sql);

$output = array('data' => array());

if ($result->num_rows > 0) {
	$x = 1;
	while ($row = $result->fetch_array()) {
		$orderId = $row[0];
		$countOrderItemSql = "SELECT count(*) FROM orders_items WHERE order_id = $orderId";
		$itemCountResult = $connect->query($countOrderItemSql);
		$itemCountRow = $itemCountResult->fetch_row();

		if ($row[5] == 1) {
			$orderStatus = "<label class='label label-success'>Completed</label>";
		} else {
			$orderStatus = "<label class='label label-danger'>Ongoing</label>";
		}

		$button =
		'<!-- Single button -->
			<div class="btn-group">
				<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				Action <span class="caret"></span>
				</button>
				<ul class="dropdown-menu">
			  	<li><a href="orders.php?o=editOrd&i='.$orderId.'" id="editOrderModalBtn"><i class="glyphicon glyphicon-edit"></i>&nbsp;&nbsp;Edit</a></li>

			    <li><a style="cursor:pointer;" type="button" onclick="printOrder('.$orderId.')"><i class="glyphicon glyphicon-print"></i>&nbsp;&nbsp;Print</a></li>
			    
			    <li><a href="button" data-toggle="modal" data-target="#removeOrderModal" id="removeOrderModalBtn" onclick="removeOrder('.$orderId.')"> <i class="glyphicon glyphicon-trash"></i>&nbsp;&nbsp;Remove</a></li>       
			  </ul>
			</div>';

			$orderDate = date('d-m-Y', strtotime($row[2]));
			$supplierName = $row[4];
			$supplierContact = $row[3];

		$output['data'][] = array(
			$x,
			$orderDate,
			$supplierName,
			$supplierContact,
			$itemCountRow,
			$orderStatus,
			$button
		);
		$x++;
	}
}

$connect->close();

echo json_encode($output);