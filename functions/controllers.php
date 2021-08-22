<?php
	require_once "../.env.php";
	function app_page($page){
		include "../templates/pages/".$page.".php";
		return true;
	}

	function app_redirect($base,$link){
		header("Location: ".$base.'/'.$link.".php");
	}

?>
