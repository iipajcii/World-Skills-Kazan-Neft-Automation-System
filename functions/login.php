<?php
	session_start();

	require_once "controllers.php";
	require_once "../.env.php";

	$_SESSION['username'] = $_POST['username'];
	$_SESSION['password'] = $_POST['password'];
	
	//Creating Connection and Query to Database
	$mysql = new mysqli($env_database['host'], $env_database['user'], $env_database['password'], $env_database['database']);
	if ($mysql->connect_error) die($mysql->connect_error);

	$query = "SELECT * FROM (employees)";
	$result = $mysql->query($query);
	if (!$result) die($mysql->error);
	
	$rows = $result->num_rows;
	//Searching to find which record matches the username and password
	for ($i = 0 ; $i < $rows ; $i++){
		$result->data_seek($i); $id = $result->fetch_assoc()['ID'];
		$result->data_seek($i); $username = $result->fetch_assoc()['Username'];
		$result->data_seek($i); $password = $result->fetch_assoc()['Password'];
		$result->data_seek($i); $is_admin = $result->fetch_assoc()['isAdmin'];
		if(($_POST['username'] == $username) && ($_POST['password'] == $password)){
			//Username and Password Match
			if($is_admin){
				app_redirect($env_base_url,'templates/pages/dashboard-maintenance-manager');
			}
			else {
				app_redirect($env_base_url,'templates/pages/dashboard-accountable-party');
			}
		}
	}
	echo "No Match";
	
	$result->close();
	$mysql->close();

?>
