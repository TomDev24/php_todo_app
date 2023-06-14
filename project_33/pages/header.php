<?php
	session_start();
	require_once($_SERVER['DOCUMENT_ROOT'] . "/doingsdone/helpers.php");
?>
<header class="main-header">
    <a href="http://localhost/doingsdone">
	<img src="http://localhost/doingsdone/img/logo.png" width="153" height="42" alt="Логотип Дела в порядке">
    </a>


    <?php if (is_auth()) { ?>
	<div class="main-header__side">
		<a class="main-header__side-item button button--plus open-modal" href="http://localhost/doingsdone/pages/form-task.php">Добавить задачу</a>

		<div class="main-header__side-item user-menu">
		    <div class="user-menu__data">
		    	<p><?php echo $_SESSION['name'] ?></p>
			<a href="http://localhost/doingsdone/pages/logout.php">Выйти</a>
		    </div>
		</div>
	</div>
    <?php } else  { ?>
		<div class="main-header__side">
			<a class="main-header__side-item button button--transparent"  href="http://localhost/doingsdone/pages/form-authorization.php">Войти</a>
		</div>
    <?php } ?>
</header>
