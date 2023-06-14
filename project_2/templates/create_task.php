<?php 
	$home = "http://localhost/todoapp";
?>

<?php echo $project_list ?>
<main class="content__main">
<h2 class="content__main-heading">Добавление задачи</h2>

<form class="form" enctype="multipart/form-data" action="<?php echo $home.'/pages/form-task.php' ?>" method="post" autocomplete="off">
  <div class="form__row">
    <label class="form__label" for="name">Название <sup>*</sup></label>
    <input class="form__input" type="text" name="name" id="name" value="" placeholder="Введите название">
  </div>

  <div class="form__row">
    <label class="form__label" for="project">Проект <sup>*</sup></label>
    <select class="form__input form__input--select" name="project" id="project">
	<?php echo $options ?>
    </select>
  </div>

  <div class="form__row">
    <label class="form__label" for="date">Дата выполнения</label>
    <input class="form__input form__input--date" type="text" name="date" id="date" value="" placeholder="Введите дату в формате ГГГГ-ММ-ДД">
  </div>

  <div class="form__row">
    <label class="form__label" for="file">Файл</label>

    <div class="form__input-file">
      <input class="visually-hidden" type="file" name="file" id="file" value="">
      <label class="button button--transparent" for="file">
	<span>Выберите файл</span>
      </label>
    </div>
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

