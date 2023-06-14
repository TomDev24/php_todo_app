<?php 
	session_start();
	require_once("../settings.php");
	require_once(PATH."/helpers.php");
	require(PATH.'/auth.php');
	require(PATH.'/db.php');

	if (!$logged)
		header("Location: ".SITE.'/pages/form-authorization.php');

	$name_error = False;
	$project_error = False;
	$date_error = False;
	$file = 'NULL';
	if (isset($_REQUEST['submit'])){
		if(strlen($_REQUEST['name']) < 4)
			$name_error = True;
		if(!$_REQUEST['project'])
			$project_error = True;
		if(!$_REQUEST['date'])
			$date_error = True;
		if (isset($_FILES['file']))
			$file = $_FILES['file']['name'];
		if (!$name_error and !$project_error and !$date_error){
			$res = create_task($db, $_REQUEST['name'], $_REQUEST['project'], $_SESSION['userid'], $_REQUEST['date'], $file);
			if ($file != 'NULL')
				move_uploaded_file($_FILES['file']['tmp_name'], PATH."/uploads/" .basename($file));
			if ($res)
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
      <?php include("project_list.php") ?>
      <main class="content__main">
        <h2 class="content__main-heading">Добавление задачи</h2>

        <form class="form" enctype="multipart/form-data" method="post" autocomplete="off">
          <div class="form__row">
            <label class="form__label" for="name">Название <sup>*</sup></label>
            <input class="form__input <?php if ($name_error) echo 'form__input--error' ?>" type="text" name="name" id="name" value="" placeholder="Введите название">
          </div>

          <div class="form__row">
            <label class="form__label" for="project">Проект <sup>*</sup></label>
            <select class="form__input form__input--select <?php if ($project_error) echo 'form__input--error' ?>" name="project" id="project">
		<?php
			$projects = get_user_projects($db, $_SESSION['userid']);
			foreach ($projects as $project){
				echo "<option value='$project[1]'>$project[1]</option>";
			}
		?>
            </select>
          </div>

          <div class="form__row">
            <label class="form__label" for="date">Дата выполнения<sup>*</sup></label>
            <input class="form__input form__input--date <?php if ($name_error) echo 'form__input--error' ?>" type="text" name="date" id="date" value="" placeholder="Введите дату в формате ГГГГ-ММ-ДД">
          </div>

          <div class="form__row">
            <label class="form__label" for="file">Файл</label>

	    <?php if ($file == 'NULL') : ?>
            <div class="form__input-file">
              <input class="visually-hidden" type="file" name="file" id="file" value="">
              <label class="button button--transparent" for="file">
                <span>Выберите файл</span>
              </label>
            </div>
	    <?php else : ?>
	    	<label class="form__label"><?php echo $file ?></label>
	    <?php endif ?>
          </div>

          <div class="form__row form__row--controls">
            <input class="button" type="submit" name="submit" value="Добавить">
          </div>
        </form>
      </main>
    </div>
  </div>
</div>

<?php include("footer.php") ?>
<script src="../flatpickr.js"></script>
<script src="../script.js"></script>
</body>
</html>
