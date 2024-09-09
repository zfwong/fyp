<?php

require_once 'core.php';

$valid['success'] = array('success' => false, 'messages' => array());

if($_POST) {
	$eventId = $_POST['editEventId'];
	$eventTitle = $_POST['editEventTitle'];
	$eventColor = $_POST['editEventColor'];
	$eventStart = $_POST['editEventStart'];
	$eventEnd = $_POST['editEventEnd'];
	$eventDesc = $_POST['editEventDesc'];
	$sqlEventStart = date('Y-m-d H:i:s', strtotime($eventStart));
	$sqlEventEnd = date('Y-m-d H:i:s', strtotime($eventEnd));

	$sql = "UPDATE event SET event_title = '$eventTitle', event_color = '$eventColor', event_desc = '$eventDesc', startdate = '$sqlEventStart', enddate = '$sqlEventEnd' WHERE event_id = '$eventId'";

	if($connect->query($sql) === TRUE) {
		$valid['success'] = true;
		$valid['messages'] = '&nbsp;&nbsp;Successfully Updated';
	} else {
		$valid['success'] = false;
		$valid['messages'] = '&nbsp;&nbsp;Error while changing the event';
	}

	$connect->close();

	echo json_encode($valid);
}