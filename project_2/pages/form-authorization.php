<?php
	session_start();
	require('../helpers.php');
	require('../database.php');

	$home = "http://localhost/todoapp";
	if (isset($_SESSION['username'])) {
		header("Location: " . $home);
	}

	$error = '';
	if ($_POST['done']){ 
		$email =  $_POST['email'];
		$password = $_POST['password'];

		$q = "SELECT * FROM users WHERE email='$email'";
		$res = mysqli_query($con, $q);
		$rows = mysqli_num_rows($res);
		$user = $res->fetch_row();

		if(!filter_var($email, FILTER_VALIDATE_EMAIL))
			$error = "* Неверный E-mail или пароль <br>";
		if (!password_verify($password, $user[3]))
			$error = "* Неверный E-mail или пароль <br>";
		if ($user and $error == '') {
			$_SESSION['user_id'] = $user[0];
			$_SESSION['username'] = $user[1];
			$_SESSION['email'] = $email;
			header("Location: " . $home);
		} else 
			$error = "* Неверный E-mail или пароль <br>";
	}

	$header = include_template('header.php', []);
	$content = include_template('login.php', ['error' => $error]);
	$footer = include_template('footer.php', []);
	echo include_template('layout.php', [	'header' => $header,
						'content' => $content,
						'footer' => $footer] );
?>
