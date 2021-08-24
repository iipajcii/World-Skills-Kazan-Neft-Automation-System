<?php
	session_start();
	require_once "../../.env.php";
?>
<header style="width:100%;">
	<nav class="navbar" role="navigation" aria-label="main navigation">
		<div class="navbar-brand">
			<a class="navbar-item" href="https://bulma.io">
				<img src="https://logo.clearbit.com/softwarekeep.com">
			</a>
			<a role="button" class="navbar-burger" aria-label="menu" aria-expanded="false" data-target="navbarBasicExample">
				<span aria-hidden="true"></span>
				<span aria-hidden="true"></span>
				<span aria-hidden="true"></span>
			</a>
		</div>
		<div id="navbarBasicExample" class="navbar-menu">
			<div class="navbar-start">
				<a href="<?php $env_pages['login']?>" class="navbar-item"></a>
			</div>
			<div class="navbar-end">
				<div class="navbar-item">
					<div class="buttons">
						<a class="button is-static"><strong>Welcome!</strong></a>
					</div>
				</div>
			</div>
		</div>
	</nav>
</header>
