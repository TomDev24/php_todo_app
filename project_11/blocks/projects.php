<?php
	session_start();
	include($_SERVER['DOCUMENT_ROOT'] . "/todoer/config.php");
	require(LOCAL_ROOT . "/db.php"); 
?>

<section class="content__side">
	<h2 class="content__side-heading">Проекты</h2>

	<nav class="main-navigation">
	    <ul class="main-navigation__list">
					<?php
					$user = $_SESSION["username"];
					$user_id = $_SESSION['user_id'];
					$query    = "SELECT * FROM `projects` WHERE author='$user_id'";
					$result = mysqli_query($con, $query) or die(mysql_error());
					$rows = mysqli_num_rows($result);
					for ($i = 0; $i < $rows; $i++){ ?>
						<?php $row = $result->fetch_row(); ?>
						<li class="main-navigation__list-item">
							<a class="main-navigation__list-item-link" href="<?php echo SITE_ROOT.'/index.php?cat='.$row[1] ?>"><?php echo $row[1] ?></a>
							<?php
								$query    = "SELECT COUNT(id) FROM `tasks` WHERE author='$user_id' AND project='$row[1]'";
								$obj = mysqli_query($con, $query) or die(mysql_error());
								$amount = $obj->fetch_row();
							?> 
							<span class="main-navigation__list-item-count"> <?php echo $amount[0] ?> </span>
						</li>
					<?php } ?>
	     </ul>
	</nav>

	<a class="button button--transparent button--plus content__side-button"
		href="<?php echo SITE_ROOT . '/pages/form-project.php' ?>" target="project_add">Добавить проект</a>
</section>


