<?php
	require "../.env.php";
	$mysql = new mysqli($env_database['host'], $env_database['user'], $env_database['password'], $env_databases['Section1']);
	if ($mysql->connect_error) die($mysql->connect_error);

	$query = "SELECT * FROM (parts)";
	$result = $mysql->query($query);
	if (!$result) die($mysql->error);
	
	$parts = [];
	for($i = 0; $row = $result->fetch_assoc(); $i++) {
		$parts[$i] = new stdClass();
    	$parts[$i]->id = $row['ID'];
    	$parts[$i]->Name = preg_replace('/[^A-Za-z0-9\-]/', ' ', $row['Name']);
    	$parts[$i]->EffectiveLife = $row['EffectiveLife'];
  	}

	header('Content-Type: application/json');
	echo json_encode($parts);
?>
