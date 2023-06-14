<?php 
	session_start();
	include($_SERVER['DOCUMENT_ROOT'] . "/todoer/config.php");
	require(LOCAL_ROOT . "/db.php"); 

	$err = 0;
	$err_msg = '';
	if (!isset($_SESSION['username'])) {
		header("Location: /todoer/pages/form-authorization.php");
	}
	if (isset($_POST['name'])) {
		$project = $_POST['name'];
		$author = $_SESSION["user_id"];

		$query = "SELECT * FROM projects WHERE project_name='$project' AND author='$author'";
		$result = mysqli_query($con, $query) or die(mysqli_error($con));
		$rows = mysqli_num_rows($result);
		if($rows > 0){
			$err = 1;
			$err_msg = "* Такой проект уже существует<br>";
		}
		if ($err != 1){
			$query = "INSERT into `projects` (project_name, author) VALUES ('$project', '$author')";
			$result = mysqli_query($con, $query);
			
			//echo mysqli_errno($con) . mysqli_error($con);
			if ($result) {
				header('Location: /todoer');
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
			<?php include(LOCAL_ROOT."/blocks/projects.php"); ?>
		      <main class="content__main">
			<h2 class="content__main-heading">Добавление проекта</h2>

			<form class="form"  action="" method="post" autocomplete="off">
			  <div class="form__row">
			    <label class="form__label" for="project_name">Название <sup>*</sup></label>

			    <input class="form__input" type="text" name="name" id="project_name" value="" placeholder="Введите название проекта">
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
	</body>
</html>
