<?php
	session_start();
	include($_SERVER['DOCUMENT_ROOT']."/todoer/config.php");
	require(LOCAL_ROOT.'/db.php'); 

	$err = 0;
	$err_msg = '';
	if (isset($_SESSION['username'])) {
		header("Location: /todoer");
	}
	if ($_POST['submit']){ 
		$email =  $_REQUEST['email'];
		if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$err = 1;
			$err_msg = "* E-mail введён некорректно<br>";
		}
		$query = "SELECT * FROM users WHERE email='$email'";
		$result = mysqli_query($con, $query) or die(mysqli_error($con));
		$rows = mysqli_num_rows($result);
		if($rows > 0){
			$err = 1;
			$err_msg = "* Пользователь с таким E-mail уже существует<br>";
		}
		$password = $_REQUEST['password'];
		if(strlen($password) < 6){
			$err = 1;
			$err_msg .= "* Пароль должен быть не меньше 6 символов <br>";
		}
		$username = $_REQUEST['name'];
		if(strlen($username) < 5){
			$err = 1;
			$err_msg .= "* Имя должно быть не меньше 5 символов <br>";
		}
		$create_datetime = date("Y-m-d");	
		if ($err != 1){
			$query    = "INSERT into `users` (username, password, email, last_notice)
					VALUES ('$username', '" . md5($password) . "', '$email', 0)";
			$result = mysqli_query($con, $query);
			if ($result)
				header('Location: ' .  SITE_ROOT . '/pages/form-authorization.php');
		}
	}
?>

<!DOCTYPE html>
<html lang="ru">
	<?php include(LOCAL_ROOT."/blocks/includes.php"); ?>
	<body>
		<div class="page-wrapper">
			<div class="container container--with-sidebar">
				<?php include("../blocks/head.php"); ?>
			<div class="content">
				<section class="content__side">
				  <p class="content__side-info">Если у вас уже есть аккаунт, авторизуйтесь на сайте</p>

				  <a class="button button--transparent content__side-button" href="<?php echo SITE_ROOT . '/pages/form-authorization.php' ?>">Войти</a>
				</section>

				<main class="content__main">
				  <h2 class="content__main-heading">Регистрация аккаунта</h2>

				  <form class="form" action="" method="post" autocomplete="off">
				    <div class="form__row">
				      <label class="form__label" for="email">E-mail <sup>*</sup></label>

				      <input class="form__input" type="text" name="email" id="email" value="" placeholder="Введите e-mail">

				    </div>

				    <div class="form__row">
				      <label class="form__label" for="password">Пароль <sup>*</sup></label>

				      <input class="form__input" type="password" name="password" id="password" value="" placeholder="Введите пароль">
				    </div>

				    <div class="form__row">
				      <label class="form__label" for="name">Имя <sup>*</sup></label>

				      <input class="form__input" type="text" name="name" id="name" value="" placeholder="Введите имя">
				    </div>

				    <div class="form__row form__row--controls">
					<?php
						if ($err_msg)
				      			echo '<p class="error-message">'.$err_msg.'</p>';
					?>

				      <input class="button" type="submit" name="submit" value="Зарегистрироваться">
				    </div>
				  </form>
				</main>
			      </div>
			</div>
		</div>

		<?php include(LOCAL_ROOT."/blocks/footer.php"); ?>
	</body>
</html>
