<?php
	session_start();
	require_once($_SERVER['DOCUMENT_ROOT'] . "/doingsdone/helpers.php");
	if (is_auth())
		header("Location: " . "http://localhost/doingsdone/");

	$mysqli = db_connect();
	$error_flag = False;
	$errors = array(array(), array());

	if (isset($_POST['submit'])) {
		if(!filter_var($_REQUEST['email'], FILTER_VALIDATE_EMAIL)) {
			$error_flag = True;
			array_push($errors[0], "* E-mail или пароль введён некорректно<br>");
		}
		if(strlen($_REQUEST['password']) < 4){
			$error_flag = True;
			array_push($errors[1], "* Длина пароля должна быть не меньше 4 символов <br>");
		}

		//$stmt = db_get_prepare_stmt($mysqli, "SELECT * FROM users WHERE email= ? AND password= ?", array($_REQUEST['email'], md5($_REQUEST['password']))); 
		$stmt = db_get_prepare_stmt($mysqli, "SELECT * FROM users WHERE email= ?", array($_REQUEST['email'])); 
		$stmt->execute();
		$result = $stmt->get_result()->fetch_array();
		if ( !password_verify($_POST['password'], $result['password']) ){
			$error_flag = True;
			if (count($errors[0]) == 0)
				array_push($errors[0], "* E-mail или пароль введён некорректно<br>");
		}
		if ($result and !$error_flag){
			$_SESSION['name'] = $result['username'];
			$_SESSION['email'] = $_REQUEST['email'];
			$_SESSION['id'] = $result['id'];
			header("Location: " . "http://localhost/doingsdone/");
		}
	}
?>

<!DOCTYPE html>
<html lang="ru">

<head>
  <meta charset="UTF-8">
  <title>Document</title>
  <link rel="stylesheet" href="../css/normalize.css">
  <link rel="stylesheet" href="../css/style.css">
</head>

<body>
<h1 class="visually-hidden">Дела в порядке</h1>

<div class="page-wrapper">
  <div class="container container--with-sidebar">
    <?php include("header.php") ?>
    <div class="content">
      <main class="content__main">
        <h2 class="content__main-heading">Вход на сайт</h2>

        <form class="form" action="" method="post" autocomplete="off">
          <div class="form__row">
            <label class="form__label" for="email">E-mail <sup>*</sup></label>

            <input class="form__input" type="text" name="email" id="email" value="" placeholder="Введите e-mail">
	     <?php if (count($errors[0]) > 0) {
	      	foreach($errors[0] as $err) {
			echo "<p class='form__message'>$err</p>";
		}	
	      } ?>
          </div>

          <div class="form__row">
            <label class="form__label" for="password">Пароль <sup>*</sup></label>

            <input class="form__input" type="password" name="password" id="password" value="" placeholder="Введите пароль">
	     <?php if (count($errors[1]) > 0) {
	      	foreach($errors[1] as $err) {
			echo "<p class='form__message'>$err</p>";
		}	
	      } ?>
          </div>
          <div class="form__row form__row--controls">
            <input class="button" type="submit" name="submit" value="Войти">
          </div>
        </form>

      </main>

    </div>

  </div>
</div>
<?php include("footer.php") ?>
</body>
</html>
