<?php
	require "../.env.php";
	header('Content-Type: application/json');
	$mysql = new mysqli($env_database['host'], $env_database['user'], $env_database['password'], $env_databases['Section2']);
	if ($mysql->connect_error) die($mysql->connect_error);

	$warehouse_id = $_POST['warehouse_id'];

	$query = "SELECT * FROM (warehouses) WHERE ID = $warehouse_id";
	$result = $mysql->query($query);
	if (!$result) die($mysql->error);
	
	$row = $result->fetch_assoc();
	$warehouse = new stdClass();
    $warehouse->id = $row['ID'];
    $warehouse->Name = preg_replace('/[^A-Za-z0-9\-]/', ' ', $row['Name']);

    //Getting Orders going into the Warehouse
  	$orders_in = [];
  	$query = "SELECT * FROM (orders) WHERE TransactionTypeID = 1 AND DestinationWarehouseID = $warehouse_id";
  	$result = $mysql->query($query);
  	if (!$result) die($mysql->error);

	for($i = 0; $row = $result->fetch_assoc(); $i++) {
		$orders_in[$i] = new stdClass();
    	$orders_in[$i]->id = $row['ID'];
  	}

  	$query = "SELECT * FROM (orders) WHERE TransactionTypeID = 2 AND DestinationWarehouseID = $warehouse_id";
  	$result = $mysql->query($query);
  	if (!$result) die($mysql->error);

	for($i = sizeof($orders_in); $row = $result->fetch_assoc(); $i++) {
		$orders_in[$i] = new stdClass();
    	$orders_in[$i]->id = $row['ID'];
  	}

    //Getting Orders going out the Warehouse
  	$orders_out = [];
  	$query = "SELECT * FROM (orders) WHERE TransactionTypeID = 2 AND SourceWarehouseID = $warehouse_id";
  	$result = $mysql->query($query);
  	if (!$result) die($mysql->error);

	for($i = sizeof($orders_in); $row = $result->fetch_assoc(); $i++) {
		$orders_out[$i] = new stdClass();
    	$orders_out[$i]->id = $row['ID'];
  	}


  	//Getting all parts going in storage
  	$parts_in = [];
  	foreach($orders_in as $order){
  		$query = "SELECT * FROM (orderitems) WHERE OrderID = $order->id";
		$result = $mysql->query($query);
		if (!$result) die($mysql->error);

		for($i = sizeof($parts_in); $row = $result->fetch_assoc(); $i++) {
			$parts_in[$i] = new stdClass();
	    	$parts_in[$i]->id = $row['ID'];
	    	$parts_in[$i]->PartID = $row['PartID'];
	    	$parts_in[$i]->BatchNumber = $row['BatchNumber'];
	    	$parts_in[$i]->Amount = $row['Amount'];
	  	}
  	}

  	//Getting the Unique Batch Number and Part ID Configuration
  	$part_types = [];
  	foreach($parts_in as $part){
  		$in_array = false;
  		$part_criteria = new stdClass();
  		$part_criteria->PartID = $part->PartID;
  		$part_criteria->BatchNumber = $part->BatchNumber;
  		$part_criteria->Amount = 0;
  		foreach($part_types as $types){
  			if($part_criteria->PartID == $types->PartID && $part_criteria->BatchNumber == $types->BatchNumber){
  				$in_array = true;
  			}
  		}
  		if(!$in_array){
  			$part_types[] = $part_criteria;
  		}
  	}
  	//Getting the Total of Unique Batch Number and Part ID Configuration
  	foreach($part_types as $type){
  		foreach($parts_in as $part){
  			if($type->PartID == $part->PartID && $type->BatchNumber == $part->BatchNumber){
  				$type->Amount += $part->Amount;
  			}
  		}
  	}
  	$parts_in = $part_types;

  	$parts_out = [];
  	foreach($orders_out as $order){
  		$query = "SELECT * FROM (orderitems) WHERE OrderID = $order->id";
		$result = $mysql->query($query);
		if (!$result) die($mysql->error);

		for($i = sizeof($parts_out); $row = $result->fetch_assoc(); $i++) {
			$parts_out[$i] = new stdClass();
	    	$parts_out[$i]->id = $row['ID'];
	    	$parts_out[$i]->PartID = $row['PartID'];
	    	$parts_out[$i]->BatchNumber = $row['BatchNumber'];
	    	$parts_out[$i]->Amount = $row['Amount'];
	  	}
  	}

  	//Getting the Unique Batch Number and Part ID Configuration
  	$part_types = [];
  	foreach($parts_out as $part){
  		$in_array = false;
  		$part_criteria = new stdClass();
  		$part_criteria->PartID = $part->PartID;
  		$part_criteria->BatchNumber = $part->BatchNumber;
  		$part_criteria->Amount = 0;
  		foreach($part_types as $types){
  			if($part_criteria->PartID == $types->PartID && $part_criteria->BatchNumber == $types->BatchNumber){
  				$in_array = true;
  			}
  		}
  		if(!$in_array){
  			$part_types[] = $part_criteria;
  		}
  	}
  	//Getting the Total of Unique Batch Number and Part ID Configuration
  	foreach($part_types as $type){
  		foreach($parts_out as $part){
  			if($type->PartID == $part->PartID && $type->BatchNumber == $part->BatchNumber){
  				$type->Amount += $part->Amount;
  			}
  		}
  	}
  	$parts_out = $part_types;

  	//Calculating the current parts by finding the difference between parts out and parts in
  	$parts = [];
  	foreach($parts_in as $part_in){
  		foreach($parts_out as $part_out){
  			if($part_in->PartID == $part_out->PartID && $part_in->BatchNumber == $part_out->BatchNumber){
  				$query = "SELECT * FROM (parts) WHERE ID = $part_in->PartID";
				$result = $mysql->query($query);
				if (!$result) die($mysql->error);
				$row = $result->fetch_assoc();

  				$part = new stdClass();
  				$part_in->Amount >= $part_out->Amount ? $part->Amount = $part_in->Amount - $part_out->Amount : $part->Amount = $part_out->Amount - $part_in->Amount;
  				$part->PartID = $part_in->PartID;
  				$part->Name = preg_replace('/[^A-Za-z0-9\-]/', ' ', $row['Name']);
  				$part->BatchNumber = $part_in->BatchNumber;
  				$parts[] = $part;
  			}
  		}
  	}

  	if($_POST['report_type'] == "current"){
		echo json_encode($parts);
  	}
  	if($_POST['report_type'] == "out_of_stock"){
  		$out_of_stock = [];
  		foreach($parts as $part){
  			if($part->Amount == 0){$out_of_stock[] = $part;}
  		}
		echo json_encode($out_of_stock);
  	}
  	if($_POST['report_type'] == "received"){
  		foreach($parts_in as $part){
  			$query = "SELECT * FROM (parts) WHERE ID = $part->PartID";
			$result = $mysql->query($query);
			if (!$result) die($mysql->error);
			$row = $result->fetch_assoc();

			$part->Name = preg_replace('/[^A-Za-z0-9\-]/', ' ', $row['Name']);
  		}
		echo json_encode($parts_in);
  	}
?>
