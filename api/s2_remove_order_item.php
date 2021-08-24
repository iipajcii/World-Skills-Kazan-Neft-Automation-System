<?php
	require "../.env.php";
	header('Content-Type: application/json');
	$mysql = new mysqli($env_database['host'], $env_database['user'], $env_database['password'], $env_databases['Section2']);
	if ($mysql->connect_error) die($mysql->connect_error);
	$id = $_POST['id'];
	$query = "DELETE FROM orderitems where ID = $id";
	$result = $mysql->query($query);
	if (!$result) die($mysql->error);

	$msg = new stdClass();
	
	if($result){
		$msg->message = "Order Item Successfully Removed";
		$msg->value = true;
		echo json_encode($msg); exit;
	}
	else {
		$msg->message = "Order Item could not be removed.";
		$msg->error = $mysql->error;
		$msg->value = false;
		echo json_encode($msg); exit;
	}

?>
