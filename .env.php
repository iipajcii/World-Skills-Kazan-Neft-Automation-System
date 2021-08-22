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
	$env_functions = [
		'login' => $env_base_url.'/functions/login.php'
	];
