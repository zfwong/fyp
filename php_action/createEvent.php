<?php

require_once 'core.php';

$valid['success'] = array('success' => false, 'messages' => array());

if ($_POST) {
	$eventTitle = $_POST['eventTitle'];
	$eventColor = $_POST['eventColor'];
	$eventStart = $_POST['eventStart'];
	$eventEnd = $_POST['eventEnd'];
	$eventDesc = $_POST['eventDesc'];
	$eventAllDay = $_POST['eventAllDay'];
	$sqlEventStart = date('y-m-d H:i:s', strtotime($eventStart));
	$sqlEventEnd = date('y-m-d H:i:s', strtotime($eventEnd));

	$sql = "INSERT INTO event (event_title, event_color, event_desc, startdate, enddate, allDay) VALUES ('$eventTitle', '$eventColor', '$eventDesc', '$sqlEventStart', '$sqlEventEnd', $eventAllDay)";

	if ($connect->query($sql) === TRUE) {
		$valid['success'] = true;
		$valid['messages'] = '&nbsp;&nbsp;Successfully Added';		
	} else {
		$valid['success'] = false;
		$valid['messages'] = '&nbsp;&nbsp;Error while adding the event';	
	}

	$connect->close();

	echo json_encode($valid);
}