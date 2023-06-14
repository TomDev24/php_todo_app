<?php
	session_start();
	$home = "http://localhost/todoapp";

	if(session_destroy()) {
	       	header("Location: " . $home);
	}
?>
