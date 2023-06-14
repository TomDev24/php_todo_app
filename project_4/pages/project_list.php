<?php 
	session_start();
	require_once(PATH.'/settings.php');
	require_once(PATH.'/db.php');
?>
<section class="content__side">
	<h2 class="content__side-heading">Проекты</h2>

	<nav class="main-navigation">
	    <ul class="main-navigation__list">
		<?php 
			$projects = get_user_projects($db, $_SESSION['userid']);
			foreach ($projects as $project) { 
				$stmt = db_get_prepare_stmt($db, "SELECT * FROM tasks WHERE user= ? AND project= ?", array($_SESSION['userid'], $project[1])); 
				$stmt->execute();
				$num = count($stmt->get_result()->fetch_all()); ?>
			<li class="main-navigation__list-item">
				<a class="main-navigation__list-item-link" href="<?php echo SITE."/index.php?project=".$project[1] ?>"><?php echo $project[1] ?></a>
				<span class="main-navigation__list-item-count"> <?php echo $num ?> </span>
			</li>
		<?php } ?>
	    </ul>
	</nav>

	<a class="button button--transparent button--plus content__side-button"
		href="<?php echo SITE.'/pages/form-project.php' ?>" target="project_add">Добавить проект</a>
</section>
