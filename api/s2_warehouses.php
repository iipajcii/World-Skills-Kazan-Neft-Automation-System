<?php
	require "../.env.php";
	$mysql = new mysqli($env_database['host'], $env_database['user'], $env_database['password'], $env_databases['Section2']);
	if ($mysql->connect_error) die($mysql->connect_error);

	$query = "SELECT * FROM (warehouses)";
	$result = $mysql->query($query);
	if (!$result) die($mysql->error);
	
	$warehouses = [];
	for($i = 0; $row = $result->fetch_assoc(); $i++) {
		$warehouses[$i] = new stdClass();
    	$warehouses[$i]->id = $row['ID'];
    	$warehouses[$i]->Name = preg_replace('/[^A-Za-z0-9\-]/', ' ', $row['Name']);
  	}

	header('Content-Type: application/json');
	echo json_encode($warehouses);
?>
