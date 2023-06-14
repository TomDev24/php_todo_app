<?php
	session_start();
	require_once("../settings.php");
	require_once("../helpers.php");
	require(PATH.'/auth.php');
	require('../db.php');
	if ($logged)
		header("Location: ".SITE);

	$email_error = False;
	$password_error = False;
	$name_error = False;
	if (isset($_REQUEST['submit'])){
		if(!filter_var($_REQUEST['email'], FILTER_VALIDATE_EMAIL))
			$email_error = True;
		if (get_user_by_email($db, $_REQUEST['email'])){
			$email_error = True;
			alert("Аккаунт с таким e-mail уже существует");
		}
		if(strlen($_REQUEST['name']) < 3)
			$name_error = True;
		if(strlen($_REQUEST['password']) < 3)
			$password_error = True;
		if(!$email_error and !$password_error and !$name_error){
			if (create_user($db, $_REQUEST['name'], password_hash($_REQUEST['password'], PASSWORD_DEFAULT), $_REQUEST['email']))
				header('Location: '.SITE.'/pages/form-authorization.php');
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
        <section class="content__side">
          <p class="content__side-info">Если у вас уже есть аккаунт, авторизуйтесь на сайте</p>
          <a class="button button--transparent content__side-button" href="form-authorization.php">Войти</a>
        </section>

        <main class="content__main">
          <h2 class="content__main-heading">Регистрация аккаунта</h2>

          <form class="form" method="post" autocomplete="off">
            <div class="form__row">
              <label class="form__label" for="email">E-mail <sup>*</sup></label>
	      <input class="form__input <?php if ($email_error) echo 'form__input--error' ?>" type="text" name="email" id="email" value="" placeholder="Введите e-mail">
            </div>

            <div class="form__row">
              <label class="form__label" for="password">Пароль <sup>*</sup></label>
              <input class="form__input <?php if ($password_error) echo 'form__input--error' ?>" type="password" name="password" id="password" value="" placeholder="Введите пароль">
            </div>

            <div class="form__row">
              <label class="form__label" for="name">Имя <sup>*</sup></label>
              <input class="form__input <?php if ($name_error) echo 'form__input--error' ?>" type="text" name="name" id="name" value="" placeholder="Введите имя">
            </div>

            <div class="form__row form__row--controls">
		<?php if ($email_error or $password_error or $name_error) { ?>
              		<p class="error-message">Пожалуйста, исправьте ошибки в форме</p>
		<?php } ?>
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
