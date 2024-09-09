<?php

require_once 'core.php';

if ($_POST) {
	$startDate = date('Y-m-d' ,strtotime($_POST['reportStart']));
	$endDate = date('Y-m-d', strtotime($_POST['reportEnd']));

	$sql = "SELECT orders.order_date, orders.supplier_id, orders.supplier_contact, orders.grand_total, supplier.supplier_name FROM orders 
	INNER JOIN supplier ON orders.supplier_id = supplier.supplier_id 
	WHERE orders.order_date >= '$startDate' AND orders.order_date <= '$endDate' AND orders.order_status = 1";
	$query = $connect->query($sql);

	$table = 
	'<div style="border:1px solid;padding:20px 10px;">
		Date Range : '.$_POST["reportStart"].' ~ '.$_POST["reportEnd"].'
		<hr />

		<table border="0" width="100%" cellpadding="5" style="border-collapse:collapse;padding:20px 0 20px 0;">
			<tr>
				<th style="border-bottom:1px solid grey;">Order Date</th>
				<th style="border-bottom:1px solid grey;">Supplier</th>
				<th style="border-bottom:1px solid grey;">Contact</th>
				<th style="border-bottom:1px solid grey;">Grand Total</th>
			</tr>';
			$totalAmount = "";
			if ($query->num_rows > 0) {	
				while ($row = $query->fetch_assoc()) {
					$table .= 
				'<tr>
					<td><center>'.date('d-m-Y', strtotime($row['order_date'])).'</center></td>
					<td><center>'.$row['supplier_name'].'</center></td>
					<td><center>'.$row['supplier_contact'].'</center></td>
					<td><center>'.$row['grand_total'].'</center></td>
				</tr>';
					$totalAmount += $row['grand_total'];
				}
			} else {
				$table .= 
				'<tr>
					<th colspan="4">No Record Available</th>
				</tr>';
			}

			if ($query->num_rows > 0) {
				$table .= 
			'<tr>
				<th colspan="3" style="border-right:1px solid grey;border-top:1px solid grey;border-bottom:1px solid grey;">Total Amount</th>
				<th style="border-top:1px solid grey;border-bottom:1px solid grey;">RM '.number_format($totalAmount,2).'</th>
			</tr>
		</table>
		<hr />
	</div>';
			} else {
				$table .= 
			'<tr>
				<th colspan="3" style="border-right:1px solid grey;border-top:1px solid grey;border-bottom:1px solid grey;">Total Amount</th>
				<th style="border-top:1px solid grey;border-bottom:1px solid grey;">'.$totalAmount.'</th>
			</tr>
		</table>
		<hr />
	</div>';
			}

	echo $table;
}