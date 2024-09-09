<?php

require_once 'core.php';

$valid['success'] = array('success' => false, 'messages' => array());

if ($_POST) {
	$userId = $_POST['userId'];
	$userLevel = $_POST['editUserLevel'];
	$userName = $_POST['editUserName'];
	$firstName = $_POST['editFirstName'];
	$lastName = $_POST['editLastName'];
	$eMail = $_POST['editEMail'];

	$sql = "UPDATE users SET user_level = '$userLevel', firstname = '$firstName', lastname = '$lastName', username = '$userName', email = '$eMail' WHERE user_id = '$userId'";

	if ($connect->query($sql)) {
		$valid['success'] = true;
		$valid['messages'] = '&nbsp;&nbsp;Successfully Updated';
	} else {		
		$valid['success'] = false;
		$valid['messages'] = '&nbsp;&nbsp;Error while updating the user';
	}

	$connect->close();

	echo json_encode($valid);
}