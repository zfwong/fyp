<?php

require_once 'core.php';

$suppId = $_POST['supplierId'];

$sql = "SELECT supplier_id, supplier_name, contact_person, supplier_address, supplier_contact, supplier_email, supplier_active, supplier_status FROM supplier WHERE supplier_id = $suppId";

$result = $connect->query($sql);

if($result->num_rows > 0) {
	$row = $result->fetch_array();
}// /if num_rows

$connect->close();

echo json_encode($row);