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
		$username = $_POST['name'];
		$email =  $_POST['email'];
		$password = $_POST['password'];

		if(!filter_var($email, FILTER_VALIDATE_EMAIL))
			$error = "* Неправильный формат email <br>";

		$q = "SELECT * FROM users WHERE email='$email'";
		$res = mysqli_query($con, $q);
		$rows = mysqli_num_rows($res);
		if($rows > 0)
			$error = "* Этот email уже занят другим пользователем <br>";

		if(strlen($password) < 5)
			$error .= "* Длина пароля должна быть не меньше 5 символов <br>";
		if(strlen($username) < 5)
			$error .= "* Имя пользователя должно быть не меньше 5 символов <br>";

		//echo "!!" . $error;
		$password = password_hash($password, PASSWORD_DEFAULT);
		if ($error == ''){
			$q = "INSERT into users (username, password, email) VALUES ('$username', '" . $password . "', '$email')";
			$res = mysqli_query($con, $q);
			if ($res)
				header('Location: ' .  $home . '/pages/form-authorization.php');
		}
	}

	$header = include_template('header.php', []);
	$content = include_template('register.php', ['error' => $error]);
	$footer = include_template('footer.php', []);
	echo include_template('layout.php', [	'header' => $header,
						'content' => $content,
						'footer' => $footer] );
?>
