<?php
	session_start();
	require('helpers.php');
	require('database.php');
	
	$user_id = $_SESSION['user_id'];
	$today = date('Y-m-d');
	$q =  "SELECT * FROM tasks WHERE user_id= '$user_id' AND due_to > '$today' AND is_done=FALSE"; 
	$res = mysqli_query($con, $q);
	$rows = mysqli_fetch_all($res);
	if(!$_SESSION['notice'] and count($rows) > 0){
		$msg = "У вас есть невыполненные задачи в ближайшее время";
	    	echo "<script>alert('$msg');</script>";
		$_SESSION['notice'] = True;
	}

	//Отмечаем задание флагом выполнено
	if (isset($_GET['check'])) {
		$task_id = $_GET['task_id'];
		$is_done = $_GET['check'];
		$q = "UPDATE tasks SET is_done='$is_done' WHERE id='$task_id'"; 
		$res = mysqli_query($con, $q);
	}

	$header = include_template('header.php', []);
	$project_list = include_template('project_list.php', []);
	$main = include_template('main.php', ['project_list' => $project_list]);
	$guest = include_template('guest.php', []);
	$footer = include_template('footer.php', []);

	if (isset($_SESSION['username']))
		$content = $main;
	else
		$content = $guest;

	echo include_template('layout.php', [	'header' => $header,
						'content' => $content,
						'footer' => $footer] );
	exit;
?>

<body>
<h1 class="visually-hidden">Дела в порядке</h1>

<div class="page-wrapper">
    <div class="container container--with-sidebar">
        <div class="content">
            <section class="content__side">
                <h2 class="content__side-heading">Проекты</h2>

                <nav class="main-navigation">
                    <ul class="main-navigation__list">
                        <li class="main-navigation__list-item">
                            <a class="main-navigation__list-item-link" href="#">Название проекта</a>
                            <span class="main-navigation__list-item-count">0</span>
                        </li>
                    </ul>
                </nav>

                <a class="button button--transparent button--plus content__side-button"
                   href="pages/form-project.html" target="project_add">Добавить проект</a>
            </section>

            <main class="content__main">
                <h2 class="content__main-heading">Список задач</h2>

                <form class="search-form" action="index.php" method="post" autocomplete="off">
                    <input class="search-form__input" type="text" name="" value="" placeholder="Поиск по задачам">

                    <input class="search-form__submit" type="submit" name="" value="Искать">
                </form>

                <div class="tasks-controls">
                    <nav class="tasks-switch">
                        <a href="/" class="tasks-switch__item tasks-switch__item--active">Все задачи</a>
                        <a href="/" class="tasks-switch__item">Повестка дня</a>
                        <a href="/" class="tasks-switch__item">Завтра</a>
                        <a href="/" class="tasks-switch__item">Просроченные</a>
                    </nav>

                    <label class="checkbox">
                        <!--добавить сюда атрибут "checked", если переменная $show_complete_tasks равна единице-->
                        <input class="checkbox__input visually-hidden show_completed" type="checkbox">
                        <span class="checkbox__text">Показывать выполненные</span>
                    </label>
                </div>

                <table class="tasks">
                    <tr class="tasks__item task">
                        <td class="task__select">
                            <label class="checkbox task__checkbox">
                                <input class="checkbox__input visually-hidden task__checkbox" type="checkbox" value="1">
                                <span class="checkbox__text">Сделать главную страницу Дела в порядке</span>
                            </label>
                        </td>

                        <td class="task__file">
                            <a class="download-link" href="#">Home.psd</a>
                        </td>

                        <td class="task__date"></td>
                    </tr>
                    <!--показывать следующий тег <tr/>, если переменная $show_complete_tasks равна единице-->
                </table>
            </main>
        </div>
    </div>
</div>
<script src="flatpickr.js"></script>
<script src="script.js"></script>
</body>
</html>
