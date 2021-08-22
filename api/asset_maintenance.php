<?php
	session_start();
	require "../.env.php";
	$mysql = new mysqli($env_database['host'], $env_database['user'], $env_database['password'], $env_databases['Section1']);
	if ($mysql->connect_error) die($mysql->connect_error);

	$query = "SELECT * FROM (emergencymaintenances) WHERE EMEndDate is NULL";
	$result = $mysql->query($query);
	if (!$result) die($mysql->error);
	
	$maintenance = [];
	$rows = $result->num_rows;
	for ($i = 0 ; $i < $rows ; $i++){
		$maintenance[$i] = new stdClass();
		$result->data_seek($i); $maintenance[$i]->id = $result->fetch_assoc()['ID'];
		$result->data_seek($i); $maintenance[$i]->AssetID = $result->fetch_assoc()['AssetID'];
		$result->data_seek($i); $maintenance[$i]->EMReportDate = $result->fetch_assoc()['EMReportDate'];
		$result->data_seek($i); $maintenance[$i]->PriorityID = $result->fetch_assoc()['PriorityID'];
	}

	foreach($maintenance as $record){
		$query = "SELECT * FROM (assets) WHERE id = " . $record->AssetID;
		$result = $mysql->query($query);
		if (!$result) die($mysql->error);

		$result->data_seek(0); $record->AssetSN   = $result->fetch_assoc()['AssetSN'];
		$result->data_seek(0); $record->AssetName = $result->fetch_assoc()['AssetName'];
		$result->data_seek(0); $record->DepartmentLocationID = $result->fetch_assoc()['DepartmentLocationID'];
		$result->data_seek(0); $record->EmployeeID = $result->fetch_assoc()['EmployeeID'];

		$query = "SELECT * FROM (employees) WHERE id = " . $record->EmployeeID;
		$result = $mysql->query($query);
		if (!$result) die($mysql->error);
		$result->data_seek(0); $record->EmployeeFirstName = $result->fetch_assoc()['FirstName'];
		$result->data_seek(0); $record->EmployeeLastName = $result->fetch_assoc()['LastName'];

		$query = "SELECT * FROM (departments) WHERE id = " . $record->DepartmentLocationID;
		$result = $mysql->query($query);
		$result->data_seek(0); $record->DepartmentName = $result->fetch_assoc()['Name'];
	}

	header('Content-Type: application/json');
	echo json_encode($maintenance);
?>
