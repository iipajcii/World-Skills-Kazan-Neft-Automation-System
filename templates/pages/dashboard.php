<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Login Page</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<script src="https://use.fontawesome.com/releases/v5.14.0/js/all.js"></script>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.3/css/bulma.min.css">
</head>
<body>
	<?php
		include "../pieces/header.php";
	?>
	<form method="post" action="<?php echo $env_pages['dashboard'];?>">
	<?php
		include "../pieces/login_form.php";
	?>
	</form>
</body>
</html>

