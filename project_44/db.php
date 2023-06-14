<?php
	require_once("settings.php");
	require_once("helpers.php");

	$db = new mysqli(DB_SERVER, DB_USER, DB_PASSWORD, DB_NAME);
	if (mysqli_connect_errno())
		echo "Database Error!" . mysqli_connect_error();

	function get_user_by_email($db, $email){
		$stmt = db_get_prepare_stmt($db, "SELECT * FROM users WHERE email = ?", array($email)); 
		$stmt->execute();
		return $stmt->get_result()->fetch_array();
	}
	function create_user($db, $name, $password, $email){
		$stmt = db_get_prepare_stmt($db, "INSERT INTO users (username, password, email) VALUES (?, ?, ?)", 
			array($_REQUEST['name'], password_hash($_REQUEST['password'], PASSWORD_DEFAULT), $_REQUEST['email'])); 
		return $stmt->execute();
	}
	function create_task($db, $name, $project, $user, $date_complete, $file){
		$stmt = db_get_prepare_stmt($db, "INSERT INTO tasks (name, project, user, date_complete, file) VALUES (?,?,?,?,?)", 
				array($name, $project, $user, $date_complete, $file)); 
		return $stmt->execute();  
	}
	function get_user_projects($db, $userid){
		$stmt = db_get_prepare_stmt($db, "SELECT * FROM projects WHERE user= ?", array($userid)); 
		$stmt->execute();
		return $stmt->get_result()->fetch_all();
	}
?>
