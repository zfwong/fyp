<?php 

require_once 'core.php';

$valid['success'] = array('success' => false, 'messages' =>array());

$userId = $_POST['userId'];

if ($userId) {
	$sql = "DELETE FROM users WHERE user_id = {$userId}";

	if ($connect->query($sql) === TRUE) {
		$valid['success'] = true;
		$valid['messages'] = "&nbsp;&nbsp;Successfully Removed";
	} else {
		$valid['success'] = false;
		$valid['messages'] = "&nbsp;&nbsp;Error while removing brand";
	}

	$connect->close();
	
	echo json_encode($valid);
}

?>