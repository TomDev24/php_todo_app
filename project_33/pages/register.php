<?php
	require_once($_SERVER['DOCUMENT_ROOT'] . "/doingsdone/helpers.php");
	if (is_auth())
		header("Location: " . "http://localhost/doingsdone/");

	$mysqli = db_connect();
	
	$error_flag = False;
	$errors = array(array(), array(), array());
	if ($_POST['submit']){ 
		if(!filter_var($_REQUEST['email'], FILTER_VALIDATE_EMAIL)) {
			$error_flag = True;
			array_push($errors[0], "* E-mail введён некорректно<br>");
		}
		$stmt = db_get_prepare_stmt($mysqli, "SELECT * FROM users WHERE email = ?", array($_REQUEST['email'])); 
		$stmt->execute();
		$result = $stmt->get_result()->fetch_array();
		if ($result){
			$error_flag = True;
			array_push($errors[0], "* Этот E-mail уже используется другим пользователем<br>");
		}
		if(strlen($_REQUEST['password']) < 4){
			$error_flag = True;
			array_push($errors[1], "* Длина пароля должна быть не меньше 4 символов <br>");
		}
		if(strlen($_REQUEST['name']) < 4){
			$error_flag = True;
			array_push($errors[2], "* Длина имени должна быть не меньше 4 символов <br>");
		}
	}
	if ($_POST['submit'] and !$error_flag){ 
		$stmt = db_get_prepare_stmt($mysqli, "INSERT INTO users (username, password, email) VALUES (?, ?, ?)", 
			array($_POST['name'], password_hash($_POST['password'], PASSWORD_DEFAULT), $_POST['email'])); 
		if ($stmt->execute())
			header('Location: http://localhost/doingsdone/pages/form-authorization.php');
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
        <section class="content__side">
          <p class="content__side-info">Если у вас уже есть аккаунт, авторизуйтесь на сайте</p>

          <a class="button button--transparent content__side-button" href="http://localhost/doingsdone/pages/form-authorization.php">Войти</a>
        </section>

        <main class="content__main">
          <h2 class="content__main-heading">Регистрация аккаунта</h2>

          <form class="form" method="post" autocomplete="off">
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

            <div class="form__row">
              <label class="form__label" for="name">Имя <sup>*</sup></label>

              <input class="form__input" type="text" name="name" id="name" value="" placeholder="Введите имя">
	       <?php if (count($errors[2]) > 0) {
	      	foreach($errors[2] as $err) {
			echo "<p class='form__message'>$err</p>";
		}	
	      } ?>

            </div>

            <div class="form__row form__row--controls">
              <input class="button" type="submit" name="submit" value="Зарегистрироваться">
            </div>
          </form>
        </main>
      </div>
    </div>
  </div>
<?php include("footer.php") ?>
</body>
</html>
