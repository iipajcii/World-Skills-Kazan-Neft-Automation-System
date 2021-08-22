<?php
	# ID | AssetID | PriorityID | DescriptionEmergency | OtherConsiderations | EMReportDate | EMStartDate | EMEndDate  | EMTechnicianNote
	require "../.env.php";
	header('Content-Type: application/json');
	$post_id = $_POST['AssetID']; 
	$post_priority_id = $_POST['PriorityID'];
	$post_description = $_POST['Description'];
	$post_considerations = $_POST['Considerations'];

	$mysql = new mysqli($env_database['host'], $env_database['user'], $env_database['password'], $env_database['database']);
	if ($mysql->connect_error) die($mysql->connect_error);

	$query = "SELECT * FROM (emergencymaintenances) WHERE AssetID = " . $post_id;
	$result = $mysql->query($query);
	if (!$result) die($mysql->error);

	$maintenances = [];
	$can_create = true;

	$rows = $result->num_rows;
	$date = date("Y-m-d");
	
	//NOTE: Logic for deciding whether to create record or not is not correct, this needs to be corrected
	$can_create = true;
	for ($i = 0 ; $i < $rows ; $i++){
		$maintenances[$i] = new stdClass();
		$result->data_seek($i); $maintenances[$i]->id = $result->fetch_assoc()['ID'];
		$result->data_seek($i); $maintenances[$i]->EMEndDate = $result->fetch_assoc()['EMEndDate'];
		if($maintenances[$i]->EMEndDate == null){$can_create = false; break;}
	}
	$msg = new stdClass();

	if(!$can_create){
		$msg->message = "Emergency Maintenance could not be created";
		$msg->error = $mysql->error;
		$msg->value = false;
		echo json_encode($msg); exit;
	}
	
	$query = "INSERT INTO emergencymaintenances (AssetID, PriorityID, DescriptionEmergency, OtherConsiderations, EMReportDate, EMStartDate, EMEndDate, EMTechnicianNote) VALUES ('$post_id', '$post_priority_id', '$post_description', '$post_considerations', '$date', NULL, NULL, NULL)";
	$result = $mysql->query($query);

	if($result){
		$msg->message = "Emergency Maintenance Created";
		$msg->value = true;
		echo json_encode($msg); exit;
	}
	else {
		$msg->message = "Emergency Maintenance could not be created";
		$msg->error = $mysql->error;
		$msg->value = false;
		echo json_encode($msg); exit;
	}

?>
