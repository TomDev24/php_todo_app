<?php
	$home = "http://localhost/todoapp";
?>
<header class="main-header">
    <a href="<?php echo $home ?>">
    	<img src="<?php echo $home.'/img/logo.png' ?>" width="153" height="42" alt="Логотип Дела в порядке">
    </a>

    <?php if (isset($_SESSION['username'])) : ?>
    <div class="main-header__side">
   	<a class="main-header__side-item button button--plus open-modal" href="<?php echo $home . "/pages/form-task.php" ?>">Добавить задачу</a>
	<div class="main-header__side-item user-menu">
	    <div class="user-menu__data">
	    	<p><?php echo $_SESSION['username'] ?></p>
		<a href="<?php echo $home . "/pages/logout.php" ?>">Выйти</a>
	    </div>
	</div>
    </div>
    <?php else: ?>
        <div class="main-header__side">
          <a class="main-header__side-item button button--transparent" href="http://localhost/todoapp/pages/form-authorization.php">Войти</a>
        </div>
    <?php endif ?>
</header>


