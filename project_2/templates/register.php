<?php
	$home = "http://localhost/todoapp";
?>
<section class="content__side">
  <p class="content__side-info">Если у вас уже есть аккаунт, авторизуйтесь на сайте</p>

  <a class="button button--transparent content__side-button" href="<?php echo $home.'/pages/form-authorization.php' ?>">Войти</a>
</section>

<main class="content__main">
  <h2 class="content__main-heading">Регистрация аккаунта</h2>

  <form class="form" action="<?php echo $home.'/pages/register.php' ?>" method="post" autocomplete="off">
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
		if ($error)
			echo '<p class="error-message">'.$error.'</p>';
	?>

      <input class="button" type="submit" name="done" value="Зарегистрироваться">
    </div>
  </form>
</main>

