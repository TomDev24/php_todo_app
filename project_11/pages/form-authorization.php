<?php 
	session_start();
	include($_SERVER['DOCUMENT_ROOT']."/todoer/config.php");
	require(LOCAL_ROOT.'/db.php'); 

	$err = 0;
	if (isset($_SESSION['username'])) {
		header("Location: /todoer");
	}
	if (isset($_POST['email'])) {
		$email =  $_POST['email'];
		$password = $_POST['password'];
		$query    = "SELECT * FROM `users` WHERE email='$email'
				AND password='" . md5($password) . "'";
		$result = mysqli_query($con, $query) or die(mysql_error());
		$rows = mysqli_num_rows($result);
		if ($rows == 1) {
			$_SESSION['username'] = $email;
			$_SESSION['user_id'] = $result->fetch_row()[0];
			header("Location: /todoer");
		} else {
			$err = 1;
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
				      <main class="content__main">
					<h2 class="content__main-heading">Вход на сайт</h2>

					<form class="form" action="" method="post" autocomplete="off">
					  <div class="form__row">
					    <label class="form__label" for="email">E-mail <sup>*</sup></label>

					    <input class="form__input <?php if ($err) echo 'form__input--error' ?>" type="text" name="email" id="email" value="" placeholder="Введите e-mail">
					    <?php 
						if ($err == 1)
					    		echo '<p class="form__message">E-mail или пароль введен неверно</p>';
					    ?>
					  </div>

					  <div class="form__row">
					    <label class="form__label" for="password">Пароль <sup>*</sup></label>

					    <input class="form__input" type="password" name="password" id="password" value="" placeholder="Введите пароль">
					  </div>

					  <div class="form__row form__row--controls">
					    <input class="button" type="submit" name="" value="Войти">
					  </div>
					</form>

				      </main>
				    </div>
			</div>
		</div>
		<?php include(LOCAL_ROOT."/blocks/footer.php"); ?>
	</body>
</html>
