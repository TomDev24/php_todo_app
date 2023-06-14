<?php 
	session_start();
	include($_SERVER['DOCUMENT_ROOT'] . "/todoer/config.php");
	require(LOCAL_ROOT . "/db.php"); 

	$err = 0;
	$err_msg = '';
	if (!isset($_SESSION['username'])) {
		header("Location: /todoer/pages/form-authorization.php");
	}
	if (isset($_POST['name'])){
		$name = $_POST['name'];
		if(strlen($name) < 4){
			$err = 1;
			$err_msg .= "* Название задачи должно быть не меньше 4 символов <br>";
		}
		$project = $_POST['project'];
		$date = $_POST['date'];
		if(!$date){
			$err = 1;
			$err_msg .= "* Дата выполнения не была указана <br>";
		}

		$user_id = $_SESSION['user_id'];

		$query = "SELECT * FROM tasks WHERE task_name='$name' AND project='$project' AND create_datetime='$date' AND author='$user_id'";
		$result = mysqli_query($con, $query) or die(mysqli_error($con));
		$rows = mysqli_num_rows($result);
		if($rows > 0){
			$err = 1;
			$err_msg = "* Такая задача уже существует<br>";
		}

		$filename = (isset($_FILES['file'])) ? $_FILES['file']['name'] : 'NULL';
		
		$query = "INSERT into `tasks` (task_name, project, author, create_datetime, filename)
				VALUES ('$name', '$project', '$user_id', '$date', '$filename')";
		if ($err != 1){	
			$result = mysqli_query($con, $query);
			if ($result) {
				if ($filename != 'NULL'){
					move_uploaded_file( $_FILES['file']['tmp_name'], LOCAL_ROOT."/uploads/".basename($filename) );
				}
				header('Location: ' . SITE_ROOT);
			}
		}
	}
?>

<!DOCTYPE html>
<html lang="ru">
	<?php include(LOCAL_ROOT."/blocks/includes.php"); ?>
	<body>
	<div class="page-wrapper">
		<div class="container container--with-sidebar">
		    <?php include("../blocks/head.php"); ?>
			<div class="content">
		    		<?php include("../blocks/projects.php"); ?>
			      <main class="content__main">
				<h2 class="content__main-heading">Добавление задачи</h2>

				<form class="form"  enctype="multipart/form-data" action="" method="post" autocomplete="off">
				  <div class="form__row">
				    <label class="form__label" for="name">Название <sup>*</sup></label>

				    <input class="form__input" type="text" name="name" id="name" value="" placeholder="Введите название">
				  </div>

				  <div class="form__row">
				    <label class="form__label" for="project">Проект <sup>*</sup></label>

				    <select class="form__input form__input--select" name="project" id="project">
							<?php
								$user = $_SESSION["username"];
								$user_id = $_SESSION['user_id'];
								$query    = "SELECT * FROM `projects` WHERE author='$user_id'";
								$result = mysqli_query($con, $query) or die(mysql_error());
								$rows = mysqli_num_rows($result);
								for ($i = 0; $i < $rows; $i++){
									$row = $result->fetch_row();
									echo "<option value='$row[1]'>$row[1]</option>";
								} 
							?>
				    </select>
				  </div>

				  <div class="form__row">
				    <label class="form__label" for="date">Дата выполнения</label>

				    <input class="form__input form__input--date" type="text" name="date" id="date" value="" placeholder="Введите дату в формате ГГГГ-ММ-ДД">
				  </div>

				  <div class="form__row">
				    <label class="form__label" for="file">Файл</label>

				    <div class="form__input-file">
				      <input class="visually-hidden" type="file" name="file" id="file">

				      <label class="button button--transparent" for="file">
					<span>Выберите файл</span>
				      </label>
				    </div>
				  </div>

				  <div class="form__row form__row--controls">
					<?php
						if ($err_msg)
				      			echo '<p class="error-message">'.$err_msg.'</p>';
					?>
				    <input class="button" type="submit" name="" value="Добавить">
				  </div>
				</form>
			      </main>
			    </div>
		</div>
	</div>
	<?php include(LOCAL_ROOT."/blocks/footer.php"); ?>
	<script src="../flatpickr.js"></script>
	<script src="../script.js"></script>
	</body>
</html>
