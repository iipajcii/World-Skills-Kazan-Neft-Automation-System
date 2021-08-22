<?php
	session_start();
	header('Content-Type: application/json');
	require "../.env.php";
	$mysql = new mysqli($env_database['host'], $env_database['user'], $env_database['password'], $env_databases['Section1']);
	if ($mysql->connect_error) die($mysql->connect_error);

	isset($_POST['AssetID']) ? $asset_id = $_POST['AssetID'] : $asset_id = $_GET['asset_id'];

	$query = "SELECT * FROM (emergencymaintenances) WHERE AssetID = $asset_id";
	$result = $mysql->query($query);
	if (!$result) die($mysql->error);
	$history = [];
	$maintenances = [];

	for($i = 0; $row = $result->fetch_assoc(); $i++) {
		$maintenances[$i] = new stdClass();
		$maintenances[$i]->id = $row['ID'];
		$maintenances[$i]->EMEndDate = $row['EMEndDate'];
	}

	// echo json_encode($maintenances); exit; //debugging
	$parts = [];
	foreach($maintenances as $maintenance){
		$query = "SELECT * FROM (changedparts) WHERE EmergencyMaintenanceID = $maintenance->id";
		$result = $mysql->query($query);
		if (!$result) die($mysql->error);

		for($i = 0; $row = $result->fetch_assoc(); $i++) {
			$part = new stdClass();
			$part->PartID = $row['PartID'];
			$part->Amount = $row['Amount'];
			$part->EmergencyMaintenanceID = $maintenance->id;
			$part->dateChanged = $maintenance->EMEndDate;

			$now = time();
			$past = strtotime($part->dateChanged);
			$date_diff = $now - $past;
			$part->daysLeft = round($date_diff / (60 * 60 * 24));
			if($part->dateChanged == null){$part->daysLeft = null;}
			$parts[] = $part;
		}
	}

	foreach($parts as $part){
		$query = "SELECT * FROM (parts) WHERE ID = $part->PartID";
		$result = $mysql->query($query);
		if (!$result) die($mysql->error);		
		for($i = 0; $row = $result->fetch_assoc(); $i++) {
			$part->Name = preg_replace('/[^A-Za-z0-9\-]/', ' ', $row['Name']);
			$parts[$i]->EffectiveLife = $row['EffectiveLife'];
		}
	}

	echo json_encode($parts);
?>
