<?php

require_once 'core.php';

$valid[] = array('success' => false, 'messages' => array());

if ($_POST) {
	$userLevel = $_POST['userLevel'];
	$userName = $_POST['userName'];
	$userPass = $_POST['userPass'];
	$sqlUserPass = md5($userPass);
	$firstName = $_POST['firstName'];
	$lastName = $_POST['lastName'];
	$eMail = $_POST['eMail'];

	$sql = "INSERT INTO users (user_level, firstname, lastname, username, password, email) VALUES ('$userLevel', '$firstName', '$lastName', '$userName', '$sqlUserPass', '$eMail')";
	
	if ($connect->query($sql) === TRUE) {
		$valid['success'] = true;
		$valid['messages'] = '&nbsp;&nbsp;Successfully Added';
	} else {
		$valid['success'] = false;
		$valid['messages'] = '&nbsp;&nbsp;Error while adding the user';
	}

	$connect->close();

	echo json_encode($valid);
}