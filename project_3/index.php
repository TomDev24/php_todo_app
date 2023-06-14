<?php 
	session_start();
	require("helpers.php");

	if (!is_auth()){
		include("pages/guest.php");
		exit();
	}
	$DATE_PATH = "http://localhost/doingsdone/index.php?date";

	$is_active = array("", "", "", "");
	if ($_GET['date'] == 'today')
		$is_active[1] = 'tasks-switch__item--active';
	else if ($_GET['date'] == 'tomorrow')
		$is_active[2] = 'tasks-switch__item--active';
	else if ($_GET['date'] == 'expired')
		$is_active[3] = 'tasks-switch__item--active';
	else
		$is_active[0] = 'tasks-switch__item--active';

	$mysqli = db_connect();
	if (isset($_GET['check'])) {
		$stmt = db_get_prepare_stmt($mysqli, "UPDATE jobs SET finished= ? WHERE id= ?", array($_GET['check'], $_GET['task_id'])); 
		$stmt->execute();
	}

	$query    = "SELECT * FROM jobs WHERE creator = ?";
	$params   = array($_SESSION['id']);
	if (isset($_GET['search']) and $_GET['search']) {
		$query    =  $query . " AND name LIKE ?";
		array_push($params, $_GET['search']);
	}
	if (isset($_GET['category']) and $_GET['category']) {
		$query    =  $query . " AND category = ?";
		array_push($params, $_GET['category']);
	}
	if (isset($_GET['show_completed']) and $_GET['show_completed'])
		$query    =  $query . " AND finished=TRUE";
	if (isset($_GET['date']) and $_GET['date']) {
		if ($_GET['date'] == 'tomorrow'){
			$datetime = date("Y-m-d", strtotime('tomorrow'));
			$query   =  $query . " AND created_at= ?";
			array_push($params, $datetime);
		}
		else if ($_GET['date'] == 'today'){
			$query   =  $query . " AND created_at= ?";
			array_push($params, date("Y-m-d"));
		}
		else {
			$query   =  $query . " AND created_at < ?";
			array_push($params, date("Y-m-d"));
		}
	}
?>
<?php include("pages/head.php") ?>
<body>
<h1 class="visually-hidden">Дела в порядке</h1>

<div class="page-wrapper">
    <div class="container container--with-sidebar">
	<?php include("pages/header.php") ?>
	<?php
		$datetime = date("Y-m-d", strtotime('tomorrow'));
		$stmt = db_get_prepare_stmt($mysqli, "SELECT * FROM jobs WHERE creator= ? AND created_at = ? AND finished=FALSE", array($_SESSION['id'], $datetime)); 
		$stmt->execute();
		$res = $stmt->get_result()->fetch_all();
		if (count($res) > 0) {
	?>
		<div class="welcome__text">
			<p style='text-align: center; background-color: #ffcccc;'><strong>У вас есть задачи на завтра</strong></p>
		</div>
	<?php } ?>
        <div class="content">
	    <?php include("pages/projects.php") ?>
            <main class="content__main">
                <h2 class="content__main-heading">Список задач</h2>

		<form class="search-form" action="" method="get" autocomplete="off">
		    <input class="search-form__input" type="text" name="search" value="<?php echo $_GET['search'] ?? ''; ?>" placeholder="Поиск по задачам">
		    <input class="search-form__submit" type="submit" name="" value="Искать">
		</form>


                <div class="tasks-controls">
                    <nav class="tasks-switch">
		    	<a href="<?php echo $DATE_PATH . "=" ?>" class="tasks-switch__item <?php echo $is_active[0] ?>">Все задачи</a>
			<a href="<?php echo $DATE_PATH . "=today" ?>" class="tasks-switch__item <?php echo $is_active[1] ?>">Повестка дня</a>
                        <a href="<?php echo $DATE_PATH . "=tomorrow" ?>" class="tasks-switch__item <?php echo $is_active[2] ?>">Завтра</a>
                        <a href="<?php echo $DATE_PATH . "=expired" ?>" class="tasks-switch__item <?php echo $is_active[3] ?>">Просроченные</a>
                    </nav>

                    <label class="checkbox">
                        <!--добавить сюда атрибут "checked", если переменная $show_complete_tasks равна единице-->
                        <input class="checkbox__input visually-hidden show_completed"  <?php if (isset($_GET['show_completed']) and $_GET['show_completed']) echo "checked"; ?> type="checkbox">
                        <span class="checkbox__text">Показывать выполненные</span>
                    </label>
                </div>

                <table class="tasks">
			<?php
				$stmt = db_get_prepare_stmt($mysqli, $query, $params); 
				$stmt->execute();
				$rows = $stmt->get_result()->fetch_all();
				foreach ($rows as $row) { ?>
					<tr class="tasks__item task">
						<td class="task__select">
							<label class="checkbox task__checkbox">
								<input class="checkbox__input visually-hidden task__checkbox"
									type="checkbox" value="<?php echo $row[0]; ?>" <?php if ($row[2]) echo "checked"; ?>>
								<span class="checkbox__text"><?php echo $row[1] ?></span>
							</label>
						</td>
						
						<?php if ($row[4]): ?>
						  <td class="task__file">
						 	<a class="download-link" href="<?php echo "http://localhost/doingsdone/uploads/".$row[4] ?>"><?php echo $row[4] ?></a>
						  </td>
						<?php else: ?>
							<td></td>
						<?php endif ?>
						<td class="task__date"><?php echo date('Y-m-d', strtotime($row[6])) ?></td>
					</tr>
			<?php } ?>
                </table>
            </main>
        </div>
    </div>
</div>

<?php include("pages/footer.php") ?>
<script src="flatpickr.js"></script>
<script src="script.js"></script>
</body>
</html>
