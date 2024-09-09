<?php

require_once 'core.php';

$sql = "SELECT startdate, event_title FROM event ORDER BY startdate ASC";
$result = $connect->query($sql);

$output = array('data' => array());

if ($result->num_rows > 0) {
	while ($row = $result->fetch_array()) {

		$output['data'][] = array(
			$row[0] = date('d F Y', strtotime($row[0])),
			$row[1]
		);// /$output
	}// /while
}// /if num_rows

$connect->close();

echo json_encode($output);