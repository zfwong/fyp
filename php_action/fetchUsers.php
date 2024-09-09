<?php

require_once 'core.php';

$sql = "SELECT users.user_id, users.user_level, users.firstname, users.lastname, users.username, users.email, users_level.user_level_name FROM users
	INNER JOIN users_level ON users.user_level = users_level.user_level";

$result = $connect->query($sql);

$output = array('data' => array());

if($result->num_rows > 0) {

	while ($row = $result->fetch_array()) {
		$userId = $row[0];

		$button = '<!-- Single button -->
		<span class="dropdown">
			<div class="btn-group">
			  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			    Action <span class="caret"></span>
			  </button>
			  <ul class="dropdown-menu">
			    <li><a href="button" data-toggle="modal" data-target="#editUserModal" onclick="editUser('.$userId.')"><i class="glyphicon glyphicon-edit"></i>&nbsp;&nbsp;Edit</a></li>
			    <li><a href="button" data-toggle="modal" data-target="#removeUserModal" onclick="removeUser('.$userId.')"><i class="glyphicon glyphicon-trash"></i>&nbsp;&nbsp;Remove</a></li>
			  </ul>
			</div>
		</span>';

		$userLevel = $row[6];
		$firstName = $row[2];
		$lastName = $row[3];
		$userName = $row[4];
		$eMail = $row[5];

		$output['data'][] = array(
			$userLevel,
			$userName,
			$firstName,
			$lastName,
			$eMail,
			$button
		);
	} // /while
} // /if num_rows

$connect->close();

echo json_encode($output);