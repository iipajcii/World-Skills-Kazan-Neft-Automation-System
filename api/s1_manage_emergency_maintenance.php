<?php
	require "../.env.php";
	header('Content-Type: application/json');
	$em_id = $_POST['id']; 
	$start_date = $_POST['start_date'];
	$end_date = $_POST['end_date'];
	$technician_note = $_POST['technician'];
	$parts = $_POST['parts'];

	$mysql = new mysqli($env_database['host'], $env_database['user'], $env_database['password'], $env_databases['Section1']);
	if ($mysql->connect_error) die($mysql->connect_error);

	$query = "UPDATE (emergencymaintenances) SET EMStartDate = '$start_date', EMEndDate = '$end_date', EMTechnicianNote = '$technician_note' WHERE id = $em_id";
	$result = $mysql->query($query);
	if (!$result) die($mysql->error);

	$parts = json_decode($parts);

	foreach($parts as $part) {
		$query = "INSERT INTO changedparts (`EmergencyMaintenanceID`, `PartID`, `Amount`) VALUES ($em_id, $part->id, $part->amount)";
		$result = $mysql->query($query);
		if (!$result) die($mysql->error);		
	}

	$msg = new stdClass();
	
	if($result){
		$msg->message = "Emergency Maintenance Updated";
		$msg->value = true;
		echo json_encode($msg); exit;
	}
	else {
		$msg->message = "Emergency Maintenance could not be updated";
		$msg->error = $mysql->error;
		$msg->value = false;
		echo json_encode($msg); exit;
	}

?>
