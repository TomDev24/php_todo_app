<?php
	session_start();
	require_once($_SERVER['DOCUMENT_ROOT'] . "/doingsdone/helpers.php");
	if (!is_auth())
		header("Location: " . "http://localhost/doingsdone/pages/form-authorization.php");

	$mysqli = db_connect();
	$error_flag = False;
	$errors = array(array(), array(), array());

	if (isset($_POST['submit'])){
		$file_name = 'NULL';
		if(strlen($_POST['name'] < 3)){
			$error_flag = True;
			array_push($errors[0], "* Название должно быть не менее 3 символов <br>");
		}
		if(!$_POST['project']){
			$error_flag = True;
			array_push($errors[1], "* Проект не указан <br>");
		}
		if(!$_POST['date']){
			$error_flag = True;
			array_push($errors[2], "* Дата не указана <br>");
		}
		if (isset($_FILES['file']))
			$file_name = $_FILES['file']['name'];

		if (!$error_flag){
			$stmt = db_get_prepare_stmt($mysqli, "INSERT INTO jobs (name, category, creator, created_at, file) VALUES (?,?,?,?,?)", 
				array($_POST['name'], $_POST['project'], $_SESSION['id'], $_POST['date'], $file_name)); 
			$ok = $stmt->execute();  
			if ($ok and $file_name != 'NULL')
				move_uploaded_file( $_FILES['file']['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . "/doingsdone/uploads/" .basename($file_name) );
			if ($ok)
				header("Location: " . "http://localhost/doingsdone/");
		}
	}
?>
<!DOCTYPE html>
<html lang="ru">

<head>
  <meta charset="UTF-8">
  <title>Document</title>
  <link rel="stylesheet" href="../css/normalize.css">
  <link rel="stylesheet" href="../css/style.css">
  <link rel="stylesheet" href="../css/flatpickr.min.css">
</head>

<body>
<h1 class="visually-hidden">Дела в порядке</h1>

<div class="page-wrapper">
  <div class="container container--with-sidebar">
    <?php include("header.php") ?>
    <div class="content">
      <?php include("projects.php") ?>
      <main class="content__main">
        <h2 class="content__main-heading">Добавление задачи</h2>

        <form class="form" enctype="multipart/form-data" action="" method="post" autocomplete="off">
          <div class="form__row">
            <label class="form__label" for="name">Название <sup>*</sup></label>

            <input class="form__input" type="text" name="name" id="name" value="" placeholder="Введите название">
	      <?php if (count($errors[0]) > 0) {
	      	foreach($errors[0] as $err) {
			echo "<p class='form__message'>$err</p>";
		}	
	      } ?>

          </div>

          <div class="form__row">
            <label class="form__label" for="project">Проект <sup>*</sup></label>

	    <select class="form__input form__input--select" name="project" id="project">
		<?php
			$stmt = db_get_prepare_stmt($mysqli, "SELECT * FROM categories WHERE creator = ?", array($_SESSION['id'])); 
			$stmt->execute();
			$rows = $stmt->get_result()->fetch_all();
			foreach ($rows as $row)
				echo "<option value='$row[1]'>$row[1]</option>";
		?>
	    </select>
            <?php if (count($errors[1]) > 0) {
	      	foreach($errors[1] as $err) {
			echo "<p class='form__message'>$err</p>";
		}	
	     } ?>

          </div>

          <div class="form__row">
            <label class="form__label" for="date">Дата выполнения</label>

            <input class="form__input form__input--date" type="text" name="date" id="date" value="" placeholder="Введите дату в формате ГГГГ-ММ-ДД">
	      <?php if (count($errors[2]) > 0) {
	      	foreach($errors[2] as $err) {
			echo "<p class='form__message'>$err</p>";
		}	
	      } ?>
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
