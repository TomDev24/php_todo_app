<?php
	session_start();
	require('../helpers.php');
	require('../database.php');

	$home = "http://localhost/todoapp";
	if (!isset($_SESSION['username']))
		header("Location: " . $home);

	$user_id = $_SESSION['user_id'];
	$error = '';
	if ($_POST['done']){ 
		$task_name = $_POST['name'];
		$project_name = $_POST['project'];
		$due_date = $_POST['date'];
		$file_name = 'NULL';

		if (isset($_FILES['file']))
			$file_name = $_FILES['file']['name'];
		if(strlen($task_name) < 3)
			$error .= "* Название должно быть не меньше 3 символов <br>";
		if(!isset($project_name))
			$error .= "* Укажите проект задачи <br>";
		if(!isset($due_date))
			$error .= "* Укажите дату выполнения <br>";
		$q = "SELECT * FROM tasks WHERE name='$task_name' AND project_name='$project_name' AND user_id='$user_id'";
		$res = mysqli_query($con, $q);
		$rows_amount = mysqli_num_rows($res);
		if($rows_amount > 0)
			$error .= "* Задача с таким именем уже существует <br>";

		if ($error == ""){
			$q = "INSERT into tasks (name, project_name, user_id, due_to, file_name) VALUES ('$task_name', '$project_name', '$user_id', '$due_date', '$file_name')";
			$res = mysqli_query($con, $q);
			if ($res and $file_name != 'NULL')
				move_uploaded_file( $_FILES['file']['tmp_name'], $_SERVER['DOCUMENT_ROOT']."/todoapp/uploads/".basename($file_name) );
			if ($res)
				header('Location: ' . $home);
		}
	}

	$q = "SELECT * FROM projects WHERE user_id='$user_id'";
	$res = mysqli_query($con, $q);
	$rows = mysqli_fetch_all($res);

	$options = '';
	foreach ($rows as $row)
		$options .= "<option value='$row[1]'>$row[1]</option>";

	$header = include_template('header.php', []);
	$project_list = include_template('project_list.php', []);
	$content = include_template('create_task.php', [ 'project_list' => $project_list, 'options' => $options, 'error' => $error]);
	$footer = include_template('footer.php', []);
	echo include_template('layout.php', [	'header' => $header,
						'content' => $content,
						'footer' => $footer] );
?>


