<?php
	session_start();
	require_once("settings.php");
	require_once("helpers.php");
	require(PATH.'/auth.php');
	require(PATH.'/db.php');

	if (!$logged)
		header("Location: pages/guest.php");
	$stmt = db_get_prepare_stmt($db, "SELECT * FROM tasks WHERE user= ? AND date_complete > ? AND is_done= ?", array($_SESSION['userid'], date("Y-m-d"), 'FALSE')); 
	$stmt->execute();
	if (count($stmt->get_result()->fetch_all()) and !isset($_SESSION['notify']) > 0){
		alert('У вас есть предстоящие задачи');
		$_SESSION['notify'] = True;
	}

	if (isset($_REQUEST['check'])) {
		$stmt = db_get_prepare_stmt($db, "UPDATE tasks SET is_done= ? WHERE id= ?", array($_REQUEST['check'], $_REQUEST['task_id'])); 
		$stmt->execute();
	}

	$query = "SELECT * FROM tasks WHERE user = ?";
	$args = array($_SESSION['userid']);
?>

<?php include("pages/html_head.php") ?>
<body>
<h1 class="visually-hidden">Дела в порядке</h1>

<div class="page-wrapper">
    <div class="container container--with-sidebar">
	<?php include("pages/header.php") ?>
        <div class="content">
		<?php include("pages/project_list.php") ?>
                <main class="content__main">
                <h2 class="content__main-heading">Список задач</h2>
		<?php include("pages/control_panel.php") ?>
                <table class="tasks">
	            <?php
			if (isset($_GET['search']) and $_GET['search'] != '') {
				$query .= " AND name LIKE ?";
				array_push($args, '%'.$_REQUEST['search'] .'%');
			}
			if (isset($_GET['project']) and $_GET['project'] != '') {
				$query .= " AND project = ?";
				array_push($args, $_GET['project']);
			}
			if (isset($_GET['show_completed']) and $_GET['show_completed'] == '1'){
				$query .= " AND is_done = TRUE";
			}
			if ($_GET['date'] == 'today' or $_GET['date'] == 'tomorrow'){
				$time = $_GET['date'] == 'today' ? date("Y-m-d") : date("Y-m-d", strtotime('tomorrow'));
				$query .= " AND date_complete= ?";
				array_push($args, $time);
			} else if($_GET['date'] == 'past'){
				$time = date('Y-m-d');
				$query .= " AND date_complete < ?";
				array_push($args, $time);
			}
			$stmt = db_get_prepare_stmt($db, $query, $args); 
			$stmt->execute();
			$tasks = $stmt->get_result()->fetch_all();
			foreach ($tasks as $task) { ?>
			    <tr class="tasks__item task">
				<td class="task__select">
				    <label class="checkbox task__checkbox">
					<input class="checkbox__input visually-hidden task__checkbox" 
						type="checkbox" value="<?php echo $task[0] ?>" <?php if ($task[4]) echo "checked"; ?>>
					<span class="checkbox__text"><?php echo $task[1] ?></span>
				    </label>
				</td>
				<td class="task__file">
			            <?php if ($task[6] != 'NULL') : ?>
					<a class="download-link" href="<?php echo SITE.'/uploads/'.$task[6] ?>"><?php echo $task[6] ?></a>
				    <?php endif ?>
				</td>
				<td class="task__date"><?php echo $task[5] ?></td>
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
