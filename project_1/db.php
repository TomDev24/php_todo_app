<?php
	$con = mysqli_connect("localhost", "root", "", "todoer");

	if (mysqli_connect_errno()){
		echo "Error. Cant connect to MySQl" . mysqli_connect_error();
	}
?>
