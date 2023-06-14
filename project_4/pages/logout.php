<?php
    require_once("../settings.php");
    session_start();
    if(session_destroy())
	header("Location: ".SITE);
?>
