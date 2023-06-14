<?php
	session_start();
	require_once("../settings.php");
	require_once("../helpers.php");
	require('../auth.php');
	require('../db.php');
	if ($logged)
		header("Location: ".SITE);

	$email_error = False;
	$password_error = False;
	if (isset($_REQUEST['submit'])) {
		if(!filter_var($_REQUEST['email'], FILTER_VALIDATE_EMAIL))
			$email_error = True;
		if(strlen($_REQUEST['password']) < 3)
			$password_error= True;
		$user = get_user_by_email($db, $_REQUEST['email']);
		if (!password_verify($_REQUEST['password'], $user['password']) ){
			$email_error = True;
			$password_error = True;
		}
		if($user and !$email_error and !$password_error){
			$_SESSION['username'] = $user['username'];
			$_SESSION['userid'] = $user['id'];
			$_SESSION['email'] = $_REQUEST['email'];
			header("Location: ".SITE);
		}
	}
?>
<?php include("html_head.php") ?>
<body>
<h1 class="visually-hidden">Дела в порядке</h1>

<div class="page-wrapper">
  <div class="container container--with-sidebar">
    <?php include("header.php") ?>
    <div class="content">
      <main class="content__main">
        <h2 class="content__main-heading">Вход на сайт</h2>

        <form class="form" method="post" autocomplete="off">
          <div class="form__row">
            <label class="form__label" for="email">E-mail <sup>*</sup></label>
            <input class="form__input <?php if ($email_error) echo 'form__input--error' ?>"  type="text" name="email" id="email" value="" placeholder="Введите e-mail">
          </div>

          <div class="form__row">
            <label class="form__label" for="password">Пароль <sup>*</sup></label>
            <input class="form__input <?php if ($password_error) echo 'form__input--error' ?>" type="password" name="password" id="password" value="" placeholder="Введите пароль">
          </div>

          <div class="form__row form__row--controls">
		<?php if ($email_error or $password_error) { ?>
              		<p class="error-message">Пожалуйста, исправьте ошибки в форме</p>
		<?php } ?>
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
