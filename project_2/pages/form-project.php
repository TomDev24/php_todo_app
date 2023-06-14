<?php
	session_start();
	require('../helpers.php');
	require('../database.php');

	$home = "http://localhost/todoapp";

	if (!isset($_SESSION['username']))
		header("Location: " . $home);

	$error = '';
	if ($_POST['done']){ 
		$project_name = $_POST['name'];
		$user_id = $_SESSION["user_id"];

		$q = "SELECT * FROM projects WHERE name='$project_name' AND user_id='$user_id'";
		$res = mysqli_query($con, $q);
		$rows = mysqli_num_rows($res);
		if($rows > 0)
			$error = "* Такой проект уже существует<br>";
		else if (strlen($project_name) < 3)
			$error .= "* Имя проекта слишком коротокое <br>";

		if ($error == ''){
			$q = "INSERT into projects (name, user_id) VALUES ('$project_name', '$user_id')";
			$res = mysqli_query($con, $q);
			
			if ($res)
				header('Location: ' . $home);
		}

	}

	$header = include_template('header.php', []);
	$project_list = include_template('project_list.php', []);
	$content = include_template('create_project.php', [ 'project_list' => $project_list, 'error' => $error]);
	$footer = include_template('footer.php', []);
	echo include_template('layout.php', [	'header' => $header,
						'content' => $content,
						'footer' => $footer] );
?>
