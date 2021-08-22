<?php
	session_start();
	require "../.env.php";
	$mysql = new mysqli($env_database['host'], $env_database['user'], $env_database['password'], $env_databases['Section1']);
	if ($mysql->connect_error) die($mysql->connect_error);

	$query = "SELECT * FROM (employees) WHERE Username = '".$_SESSION['username']."'";
	$result = $mysql->query($query);
	if (!$result) die($mysql->error);

	$user = new stdClass();
	$result->data_seek(0); $user->id  = $result->fetch_assoc()['ID'];
	$result->data_seek(0); $user->first_name = $result->fetch_assoc()['FirstName'];
	$result->data_seek(0); $user->last_name  = $result->fetch_assoc()['LastName'];


	$query = "SELECT * FROM (assets) WHERE EmployeeID = '".$user->id."'";
	$result = $mysql->query($query);
	if (!$result) die($mysql->error);
	
	$rows = $result->num_rows;
	$assets = [];
	//Searching to find which record matches the username and password
	for ($i = 0 ; $i < $rows ; $i++){
		$assets[$i] = new stdClass();
		$result->data_seek($i); $assets[$i]->id = $result->fetch_assoc()['ID'];
		$result->data_seek($i); $assets[$i]->AssetSN  = $result->fetch_assoc()['AssetSN'];
		$result->data_seek($i); $assets[$i]->AssetName  = $result->fetch_assoc()['AssetName'];
		$result->data_seek($i); $assets[$i]->DepartmentLocationID = $result->fetch_assoc()['DepartmentLocationID'];
		$assets[$i]->LastClosedEM  = null;
		$assets[$i]->DepartmentName = null;
		$assets[$i]->NumberOfEMs = 0;
	}

	$query = "SELECT * FROM (emergencymaintenances)";
	$result = $mysql->query($query);
	if (!$result) die($mysql->error);
	
	$maintenance = [];
	$rows = $result->num_rows;
	for ($i = 0 ; $i < $rows ; $i++){
		$maintenance[$i] = new stdClass();
		$result->data_seek($i); $maintenance[$i]->id = $result->fetch_assoc()['ID'];
		$result->data_seek($i); $maintenance[$i]->asset_id = $result->fetch_assoc()['AssetID'];
		$result->data_seek($i); $maintenance[$i]->EMEndDate = $result->fetch_assoc()['EMEndDate'];
		foreach($assets as $asset){
			if($maintenance[$i]->asset_id == $asset->id){
				if($asset->LastClosedEM == null){$asset->LastClosedEM = $maintenance[$i]->EMEndDate;}
				else if($maintenance[$i]->EMEndDate > $asset->LastClosedEM){$asset->LastClosedEM = $maintenance[$i]->EMEndDate;}
				$asset->NumberOfEMs++;
			}
		}
	}

	$query = "SELECT * FROM (departments)";
	$result = $mysql->query($query);
	if (!$result) die($mysql->error);
	
	$departments = [];
	$rows = $result->num_rows;
	for ($i = 0 ; $i < $rows ; $i++){
		$departments[$i] = new stdClass();
		$result->data_seek($i); $departments[$i]->id = $result->fetch_assoc()['ID'];
		$result->data_seek($i); $departments[$i]->name = $result->fetch_assoc()['Name'];
		foreach($assets as $asset){
			if($departments[$i]->id == $asset->DepartmentLocationID){
				$asset->DepartmentName = $departments[$i]->name;
			}
		}
	}

	header('Content-Type: application/json');
	echo json_encode($assets);
?>
