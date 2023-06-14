<?php 
	session_start();
	require_once($_SERVER['DOCUMENT_ROOT'] . "/doingsdone/helpers.php");
	if (!is_auth())
		header("Location: " . "http://localhost/doingsdone/pages/form-authorization.php");

	$mysqli = db_connect();
	$error_flag = False;
	$errors = array();

	if (isset($_POST['submit'])) {
		$stmt = db_get_prepare_stmt($mysqli, "SELECT * FROM categories WHERE name= ? AND creator= ?", array($_REQUEST['name'], $_SESSION['id'])); 
		$stmt->execute();
		$result = $stmt->get_result()->fetch_array();
		if($result){
			$error_flag = True;
			array_push($errors, "* Такой проект уже создан<br>");
		}
		if (strlen($_REQUEST['name']) < 2){
			$error_flag = True;
			array_push($errors, "* Название проекта должно содержать не меньше 2 символов <br>");
		}
		if (!$error_flag){
			$stmt = db_get_prepare_stmt($mysqli, "INSERT into categories (name, creator) VALUES (?, ?)", array($_REQUEST['name'], $_SESSION['id'])); 
			if ($stmt->execute()) 
				header("Location: " . "http://localhost/doingsdone");
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
</head>

<body>
<h1 class="visually-hidden">Дела в порядке</h1>

<div class="page-wrapper">
  <div class="container container--with-sidebar">
    <?php include("header.php") ?>
    <div class="content">
      <?php include("projects.php") ?>
      <main class="content__main">
        <h2 class="content__main-heading">Добавление проекта</h2>

        <form class="form"  action="" method="post" autocomplete="off">
          <div class="form__row">
            <label class="form__label" for="project_name">Название <sup>*</sup></label>

            <input class="form__input" type="text" name="name" id="project_name" value="" placeholder="Введите название проекта">
	      <?php if (count($errors) > 0) {
	      	foreach($errors as $err) {
			echo "<p class='form__message'>$err</p>";
		}	
	      } ?>

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
</body>
</html>
