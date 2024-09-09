<?php

require_once 'core.php';

$valid['success'] = array('success' => false, 'messages' => array());

$eventId = $_POST['eventId'];

if ($eventId) {
	$sql = "DELETE FROM event WHERE event_id = {$eventId}";

	if ($connect->query($sql) === TRUE) {
		$valid['success'] = true;
		$valid['messages'] = '&nbsp;&nbsp;Successfully Removed';
	} else {
		$valid['success'] = false;
		$valid['messages'] = '&nbsp;&nbsp;Error while updating the event';
	}
}

$connect->close();

echo json_encode($valid);