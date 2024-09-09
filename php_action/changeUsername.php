<?php

require_once 'core.php';

if ($_POST) {
	$valid['success'] = array('success' => false, 'messages' => array());

	$username = $_POST['settingUsername'];
	$userId = $_POST['user_id'];

	$sql = "UPDATE users SET username = '$username' WHERE user_id = {$userId}";

	if ($connect->query($sql) === TRUE) {
		$valid['success'] = true;
		$valid['messages'] = '&nbsp;&nbsp;Successfully Updated';
	} else {
		$valid['success'] = false;
		$valid['messages'] = '&nbsp;&nbsp;Error while changing the username';		
	}

	$connect->close();

	echo json_encode($valid);
}// /if $_POST