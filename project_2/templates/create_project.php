<?php 
	$home = "http://localhost/todoapp";
?>

<?php echo $project_list ?>
<main class="content__main">
<h2 class="content__main-heading">Добавление проекта</h2>

<form class="form"  action="<?php echo $home . "/pages/form-project.php" ?>" method="post" autocomplete="off">
  <div class="form__row">
    <label class="form__label" for="project_name">Название <sup>*</sup></label>
    <input class="form__input" type="text" name="name" id="project_name" value="" placeholder="Введите название проекта">
  </div>

  <div class="form__row form__row--controls">
	<?php
		if ($error)
			echo '<p class="error-message">'.$error.'</p>';
	?>
    <input class="button" type="submit" name="done" value="Добавить">
  </div>
</form>
</main>
