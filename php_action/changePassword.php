<?php

require_once 'core.php';

if ($_POST) {
	$valid['success'] = array('success' => false, 'messages' => array());

	$currentPassword = md5($_POST['currentPassword']);
	$newPassword = md5($_POST['newPassword']);
	$confirmPassword = md5($_POST['confirmPassword']);
	$userId = $_POST['user_id'];

	$sql = "SELECT * FROM users WHERE user_id = {$userId}";
	$query = $connect->query($sql);
	$result = $query->fetch_assoc();

	if ($currentPassword == $result['password']) {
		if ($newPassword == $confirmPassword) {
			$updateSql = "UPDATE users SET password = '$newPassword' WHERE user_id = {$userId}";
			if ($connect->query($updateSql) === TRUE) {
				$valid['success'] = true;
				$valid['messages'] = '&nbsp;&nbsp;Successfully updated';
			} else{
				$valid['success'] = false;
				$valid['messages'] = '&nbsp;&nbsp;Error while changing the password';				
			}
		} else {
			$valid['success'] = false;
			$valid['messages'] = '&nbsp;&nbsp;New Password doesn\'t match with Confirm Password';
		}
	} else {
		$valid['success'] = false;
		$valid['messages'] = '&nbsp;&nbsp;Current Password is incorrect';
	}

	$connect->close();

	echo json_encode($valid);
}