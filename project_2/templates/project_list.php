<?php
	$path = $_SERVER['DOCUMENT_ROOT'] . '/todoapp';
	$home = "http://localhost/todoapp";

	require($path . '/database.php');

	$user_id = $_SESSION['user_id'];
	$q = "SELECT * FROM projects WHERE user_id='$user_id'";
	$res = mysqli_query($con, $q);
	$rows = mysqli_fetch_all($res);

	function count_task($msql, $project_name){
		$user_id = $_SESSION['user_id'];
		$q = "SELECT COUNT(name) FROM tasks WHERE user_id='$user_id' AND project_name='$project_name'";
		$res = mysqli_query($msql, $q);
		return $res->fetch_row()[0];
	}
?>
<section class="content__side">
<h2 class="content__side-heading">Проекты</h2>

<nav class="main-navigation">
  <ul class="main-navigation__list">
	<?php foreach($rows as $row) { ?>
	    <li class="main-navigation__list-item <?php if ($_GET['project'] == $row[1]) echo 'main-navigation__list-item--active'?> ">
		<a class="main-navigation__list-item-link" href="<?php echo $home . "/index.php?project=".$row[1] ?>"><?php echo $row[1] ?></a>
		<span class="main-navigation__list-item-count"><?php echo count_task($con, $row[1]); ?></span>
	    </li>
	<?php } ?>
  </ul>
</nav>

<a class="button button--transparent button--plus content__side-button" href="<?php echo $home . "/pages/form-project.php" ?>">Добавить проект</a>
</section>


