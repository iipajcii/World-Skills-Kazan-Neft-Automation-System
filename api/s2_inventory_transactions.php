<?php
	require "../.env.php";
	$mysql = new mysqli($env_database['host'], $env_database['user'], $env_database['password'], $env_databases['Section2']);
	if ($mysql->connect_error) die($mysql->connect_error);

	$query = "SELECT * FROM (orderitems)";
	$result = $mysql->query($query);
	if (!$result) die($mysql->error);

	$parts = [];
	for($i = 0; $row = $result->fetch_assoc(); $i++) {
		$parts[$i] = new stdClass();
		$parts[$i]->id = $row['ID'];
		$parts[$i]->PartID = $row['PartID'];
		$parts[$i]->Amount = $row['Amount'];
		$parts[$i]->OrderID = $row['OrderID'];
	}

	foreach($parts as $part){
		//Get Transaction Type ID
		$query = "SELECT * FROM (orders) WHERE ID = $part->OrderID";
		$result = $mysql->query($query);
		if (!$result) die($mysql->error);
		$row = $result->fetch_assoc();
		$part->TransactionTypeID = $row['TransactionTypeID'];
		$part->Date = $row['Date'];
		$part->SourceWarehouseID = $row['SourceWarehouseID'];
		$part->DestinationWarehouseID = $row['DestinationWarehouseID'];

		//Get Transaction Type Name
		$query = "SELECT * FROM (transactiontypes) WHERE ID = $part->TransactionTypeID";
		$result = $mysql->query($query);
		if (!$result) die($mysql->error);
		$row = $result->fetch_assoc();
		$part->TransactionName = $row['Name'];

		//Get Warehouse Locations
		if($part->SourceWarehouseID != null){
			$query = "SELECT * FROM (warehouses) WHERE ID = $part->SourceWarehouseID";
			$result = $mysql->query($query);
			if (!$result) die($mysql->error);
			$row = $result->fetch_assoc();
			$part->SourceWarehouseName = $row['Name'];
		}
		else {
			$part->SourceWarehouseName = null;
		}

		if($part->DestinationWarehouseID != null){
			$query = "SELECT * FROM (warehouses) WHERE ID = $part->DestinationWarehouseID";
			$result = $mysql->query($query);
			if (!$result) die($mysql->error);
			$row = $result->fetch_assoc();
			$part->DestinationWarehouseName = $row['Name'];
		}
		else {
			$part->DestinationWarehouseName = null;
		}
	}

	foreach($parts as $part){
		$query = "SELECT * FROM (parts) WHERE ID = $part->PartID";
		$result = $mysql->query($query);
		if (!$result) die($mysql->error);
		$row = $result->fetch_assoc();
		$part->Name = preg_replace('/[^A-Za-z0-9\-]/', ' ', $row['Name']);
	}

	header('Content-Type: application/json');
	echo json_encode($parts);
?>
