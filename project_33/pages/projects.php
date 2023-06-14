 <?php
	session_start();
	require_once($_SERVER['DOCUMENT_ROOT'] . "/doingsdone/helpers.php");

	$mysqli = db_connect();
?>

<section class="content__side">
        <h2 class="content__side-heading">Проекты</h2>

        <nav class="main-navigation">
	    <ul class="main-navigation__list">
		<?php
		$stmt = db_get_prepare_stmt($mysqli, "SELECT * FROM categories WHERE creator= ?", array($_SESSION['id'])); 
		$stmt->execute();
		$rows = $stmt->get_result()->fetch_all();

		foreach ($rows as $row) { 
			$stmt = db_get_prepare_stmt($mysqli, "SELECT COUNT(id) FROM jobs WHERE creator= ? AND category= ?", array($_SESSION['id'], $row[1])); 
			$stmt->execute();
			$count = $stmt->get_result()->fetch_array()[0]; ?>
			<li class="main-navigation__list-item">
				<a class="main-navigation__list-item-link" href="<?php echo "http://localhost/doingsdone/index.php?category=".$row[1] ?>"><?php echo $row[1] ?></a>
				<span class="main-navigation__list-item-count"> <?php echo $count ?> </span>
			</li>
		<?php } ?>
	     </ul>
        </nav>
        <a class="button button--transparent button--plus content__side-button" href="http://localhost/doingsdone/pages/form-project.php">Добавить проект</a>
</section>

