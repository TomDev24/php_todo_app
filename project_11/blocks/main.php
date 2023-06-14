<div class="content">
	<?php include(LOCAL_ROOT."/blocks/projects.php"); ?> 
    <main class="content__main">
	<h2 class="content__main-heading">Список задач</h2>

	<form class="search-form" action="" method="get" autocomplete="off">
	    <input class="search-form__input" type="text" name="search" value="<?php echo $_GET['search'] ?? ''; ?>" placeholder="Поиск по задачам">
	    <input class="search-form__submit" type="submit" name="" value="Искать">
	</form>

	<div class="tasks-controls">
	    <nav class="tasks-switch">
		<a href="<?php echo SITE_ROOT.'/index.php?time=all' ?>" class="tasks-switch__item <?php if ($_GET['time'] == 'all' or !$_GET['time']) echo 'tasks-switch__item--active'?>">Все задачи</a>
		<a href="<?php echo SITE_ROOT.'/index.php?time=today' ?>" class="tasks-switch__item <?php if ($_GET['time'] == 'today') echo 'tasks-switch__item--active'?>">Повестка дня</a>
		<a href="<?php echo SITE_ROOT.'/index.php?time=tommorow' ?>"  class="tasks-switch__item <?php if ($_GET['time'] == 'tommorow') echo 'tasks-switch__item--active'?>">Завтра</a>
		<a href="<?php echo SITE_ROOT.'/index.php?time=late' ?>"  class="tasks-switch__item <?php if ($_GET['time'] == 'late') echo 'tasks-switch__item--active'?>">Просроченные</a>
	    </nav>

	    <label class="checkbox">
		<!--добавить сюда атрибут "checked", если переменная $show_complete_tasks равна единице-->
		<input class="checkbox__input visually-hidden show_completed" type="checkbox" <?php if (isset($_GET['show_completed'])) echo "checked"; ?>>
		<span class="checkbox__text">Показывать выполненные</span>
	    </label>
	</div>

	<table class="tasks">
			<?php
				if (isset($_GET['check'])) {
					$proj_id = $_GET['task_id'];
					$val = $_GET['check'];
					$q = "UPDATE tasks SET done='$val' WHERE id='$proj_id'"; 
					$res = mysqli_query($con, $q) or die(mysqli_error($con));
				}
				$query    = "SELECT * FROM `tasks` WHERE author='$user_id'";
				if (isset($_GET['search'])) {
					$search_word = $_GET['search'];
					$query    =  $query . " AND task_name LIKE '%$search_word%'";
				} if (isset($_GET['cat'])) {
					$category = $_GET['cat'];
					$query    =  $query . " AND project ='$category'";
				}if (isset($_GET['show_completed'])) {
					$query    =  $query . " AND done=1";
				}if (isset($_GET['time']) and $_GET['time'] != 'all') {
					if ($_GET['time'] == 'today'){
						$cdate = date('Y-m-d');
						$query   =  $query . " AND create_datetime='$cdate'";
					}
					if ($_GET['time'] == 'tommorow'){
						$cdate = new DateTime('tomorrow');
						$cdate = $cdate->format('Y-m-d');
						$query   =  $query . " AND create_datetime='$cdate'";
					}
					if ($_GET['time'] == 'late'){
						$cdate = date('Y-m-d');
						$query   =  $query . " AND create_datetime < '$cdate'";
					}
				}
				//$user = $_SESSION["username"]; //$user_id = $_SESSION['user_id'];
				$result = mysqli_query($con, $query) or die(mysqli_error($con));
				$rows = mysqli_num_rows($result);
				for ($i = 0; $i < $rows; $i++){ ?>
					<?php $row = $result->fetch_row() ?>
					<tr class="tasks__item task">
						<td class="task__select">
							<label class="checkbox task__checkbox">
								<input class="checkbox__input visually-hidden task__checkbox"
									type="checkbox" value="<?php echo $row[0]; ?>" <?php if ($row[4]) echo "checked"; ?>>
								<span class="checkbox__text"><?php echo $row[1] ?></span>
							</label>
						</td>
						
						<?php if ($row[6]): ?>
						<td class="task__file">
						<a class="download-link" href="<?php echo SITE_ROOT . '/uploads/'.$row[6] ?>"><?php echo $row[6] ?></a>
						</td>
						<?php else: ?>
							<td></td>
						<?php endif ?>

						<td class="task__date"><?php echo $row[5] ?></td>
					</tr>
			<?php } ?>
	    <!--показывать следующий тег <tr/>, если переменная $show_complete_tasks равна единице-->
	</table>
    </main>
</div>
