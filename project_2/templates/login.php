<?php
	$home = "http://localhost/todoapp";
?>

<main class="content__main">
<h2 class="content__main-heading">Вход на сайт</h2>

<form class="form" action="<?php echo $home . '/pages/form-authorization.php'?>" method="post" autocomplete="off">
  <div class="form__row">
    <label class="form__label" for="email">E-mail <sup>*</sup></label>
    <input class="form__input" type="text" name="email" id="email" value="" placeholder="Введите e-mail">
  </div>

  <div class="form__row">
    <label class="form__label" for="password">Пароль <sup>*</sup></label>
    <input class="form__input" type="password" name="password" id="password" value="" placeholder="Введите пароль">
  </div>

  <div class="form__row form__row--controls">
	<?php
		if ($error)
			echo '<p class="error-message">'.$error.'</p>';
	?>
    <input class="button" type="submit" name="done" value="Войти">
  </div>
</form>

</main>
