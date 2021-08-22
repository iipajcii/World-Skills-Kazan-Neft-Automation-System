<?php
	$env_base_url = "http://localhost/WorldSkills";
	$env_database = [
		"user" => "world_skills",
		"password" => "password",
		"database" => "Section1",
		"host" => "localhost"
	];
	$env_pages = [
		'login' => $env_base_url.'/templates/pages/login.php',
		'dashboard' => $env_base_url.'/templates/pages/dashboard.php'
	];
	$env_api = [
		'assets' => $env_base_url.'/api/asset_list.php',
		'create_emergency_maintenance' => $env_base_url.'/api/create_emergency_maintenance.php',
		'asset_maintenance' => $env_base_url.'/api/asset_maintenance.php',
		'parts' => $env_base_url.'/api/parts.php',
		'asset_history' => $env_base_url.'/api/asset_history.php',
	];
	$env_functions = [
		'login' => $env_base_url.'/functions/login.php'
	];
