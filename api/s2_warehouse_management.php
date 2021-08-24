<?php
	require "../.env.php";
	header('Content-Type: application/json');

	$source_warehouse = $_POST['source_warehouse']; 
	$destination_warehouse = $_POST['destination_warehouse']; 
	$date = $_POST['date']; 
	$parts = $_POST['parts']; 

	if(isset($_POST['source_warehouse']) && isset($_POST['destination_warehouse'])){
		$transaction_type = 2;
	}

	$mysql = new mysqli($env_database['host'], $env_database['user'], $env_database['password'], $env_databases['Section2']);
	if ($mysql->connect_error) die($mysql->connect_error);
	$query = "INSERT INTO orders (TransactionTypeID, SupplierID, SourceWarehouseID, DestinationWarehouseID, `Date`) VALUES ('$transaction_type', NULL, '$source_warehouse', '$destination_warehouse', '$date')";
	$result = $mysql->query($query);
	if (!$result) die($mysql->error);

	$query = "SELECT * FROM orders";
	$result = $mysql->query($query);
	if (!$result) die($mysql->error);

	//Get Highest id in orders
	$order_id = 0;
	for($i = 0; $row = $result->fetch_assoc(); $i++) {
		if($row['ID'] > $order_id){$order_id = $row['ID'];}
	}

	$parts = json_decode($parts);

	foreach($parts as $part) {
		$query = "INSERT INTO orderitems (`OrderID`, `PartID`, `BatchNumber`, `Amount`) VALUES ($order_id, $part->id, $part->batch, $part->amount)";
		$result = $mysql->query($query);
		if (!$result) die($mysql->error);		
	}


	$msg = new stdClass();

	if($result){
		$msg->message = "Order and Parts Created";
		$msg->value = true;
		echo json_encode($msg); exit;
	}
	else {
		$msg->message = "Order and Parts could not be created";
		$msg->error = $mysql->error;
		$msg->value = false;
		echo json_encode($msg); exit;
	}
?>
