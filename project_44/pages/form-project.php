<?php
	session_start();
	require_once("../settings.php");
	require_once(PATH."/helpers.php");
	require(PATH.'/auth.php');
	require(PATH.'/db.php');

	if (!$logged)
		header("Location: ".SITE.'/pages/form-authorization.php');

	$name_error = False;
	if (isset($_REQUEST['submit'])){
		$stmt = db_get_prepare_stmt($db, "SELECT * FROM projects WHERE name= ? AND user= ?", array($_REQUEST['name'], $_SESSION['userid'])); 
		$stmt->execute();
		$project = $stmt->get_result()->fetch_array();
		if($project)
			$name_error = True;
		if (strlen($_REQUEST['name']) < 3)
			$name_error = True;
		if (!$name_error){
			$stmt = db_get_prepare_stmt($db, "INSERT into projects (name, user) VALUES (?, ?)", array($_REQUEST['name'], $_SESSION['userid'])); 
			if ($stmt->execute()) 
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
        <h2 class="content__main-heading">Добавление проекта</h2>
        <form class="form" method="post" autocomplete="off">
          <div class="form__row">
            <label class="form__label" for="project_name">Название <sup>*</sup></label>
            <input class="form__input <?php if ($name_error) echo 'form__input--error' ?>" type="text" name="name" id="project_name" value="" placeholder="Введите название проекта">
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
