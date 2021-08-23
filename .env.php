<?php
	$env_base_url = "http://localhost/WorldSkills";
	$env_database = [
		"user" => "world_skills",
		"password" => "password",
		"host" => "localhost"
	];
	$env_databases = [
		'Section1' => 'Section1',
		'Section2' => 'Section2'
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
		's2_inventory_transactions' => $env_base_url.'/api/s2_inventory_transactions.php',
		's2_suppliers' => $env_base_url.'/api/s2_suppliers.php',
		's2_warehouses' => $env_base_url.'/api/s2_warehouses.php',
		's2_parts' => $env_base_url.'/api/s2_parts.php',
		's2_inventory_report' => $env_base_url.'/api/s2_inventory_report.php',
	];
	$env_functions = [
		'login' => $env_base_url.'/functions/login.php'
	];
