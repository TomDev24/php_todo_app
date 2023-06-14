<?php
	$path = $_SERVER['DOCUMENT_ROOT'] . '/todoapp';
	$home = "http://localhost/todoapp";
	$time = $home . "/index.php?date=";

	require($path . '/database.php');	

	$user_id = $_SESSION['user_id']; 
	$query = "SELECT * FROM tasks WHERE user_id='$user_id'";

	if (isset($_GET['show_completed']))
		$query =  $query . " AND is_done=TRUE";
	if (isset($_GET['search'])) {
		$searching = $_GET['search'];
		$query =  $query . " AND name LIKE '%$searching%'";
	}
	if (isset($_GET['project'])) {
		$project_name = $_GET['project'];
		$query =  $query . " AND project_name ='$project_name'";
	}
	$due_date = date('Y-m-d');
	if ($_GET['date'] == 'today')
		$query   =  $query . " AND due_to='$due_date'";
	if ($_GET['date'] == 'outdated')
		$query   =  $query . " AND due_to<'$due_date'";
	$due_date = date("Y-m-d", strtotime('tomorrow'));
	if ($_GET['date'] == 'tomorrow')
		$query   =  $query . " AND due_to='$due_date'";

	$res = mysqli_query($con, $query);
	$rows = mysqli_fetch_all($res);
?>

    <?php echo $project_list ?>
    <main class="content__main">
	<h2 class="content__main-heading">Список задач</h2>

	<form class="search-form" action="<?php echo $home . '/index.php'?> " method="get" autocomplete="off">
	    <input class="search-form__input" type="text" name="search" value="<?php echo $_GET['search'] ?? ''; ?>"  placeholder="Поиск по задачам">
	    <input class="search-form__submit" type="submit" name="" value="Искать">
	</form>

	<div class="tasks-controls">
	    <nav class="tasks-switch">
	    	<a href="<?php echo $time . "" ?>" class="tasks-switch__item <?php if (!isset($_GET['date']) or $_GET['date'] == '') echo 'tasks-switch__item--active'?>">Все задачи</a>
		<a href="<?php echo $time . "today" ?>" class="tasks-switch__item <?php if ($_GET['date'] == 'today') echo 'tasks-switch__item--active'?> ">Повестка дня</a>
		<a href="<?php echo $time . "tomorrow"?>" class="tasks-switch__item <?php if ($_GET['date'] == 'tomorrow') echo 'tasks-switch__item--active'?>">Завтра</a>
		<a href="<?php echo $time . "outdated"?>" class="tasks-switch__item <?php if ($_GET['date'] == 'outdated') echo 'tasks-switch__item--active'?>">Просроченные</a>
	    </nav>

	    <label class="checkbox">
		<input class="checkbox__input visually-hidden show_completed" type="checkbox" <?php if ($_GET['show_completed']) echo "checked"; ?>>
		<span class="checkbox__text">Показывать выполненные</span>
	    </label>
	</div>

	<table class="tasks">
	    <?php foreach($rows as $row){ ?>
		<tr class="tasks__item task">
			<td class="task__select">
				<label class="checkbox task__checkbox">
					<input class="checkbox__input visually-hidden task__checkbox"
						type="checkbox" value="<?php echo $row[0]; ?>" <?php if ($row[4]) echo "checked"; ?>>
					<span class="checkbox__text"><?php echo $row[1] ?></span>
				</label>
			</td>
			<?php if ($row[6]) { ?>
				<td class="task__file">
					<a class="download-link" href="<?php echo $home . '/uploads/'.$row[6] ?>"><?php echo $row[6] ?></a>
				</td>
			<?php } else { ?> <td></td> <?php } ?>
			<td class="task__date"><?php echo date('Y-m-d', strtotime($row[5]))?></td>
		</tr>
	    <?php } ?>
	</table>
    </main>

