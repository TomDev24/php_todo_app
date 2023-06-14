<?php
	session_start();
	include($_SERVER['DOCUMENT_ROOT']."/todoer/config.php")
?>
<header class="main-header">
      <a href="<?php echo SITE_ROOT; ?>">
      	<img src="<?php echo SITE_ROOT . '/img/logo.png'; ?>" width="153" height="42" alt="Логитип Дела в порядке">
      </a>

	<?php if (!isset($_SESSION["username"])): ?>
		<div class="main-header__side">
			<a class="main-header__side-item button button--transparent"  href="<?php echo SITE_ROOT . '/pages/form-authorization.php' ?>">Войти</a>
		</div>
	<?php else: ?>
		<div class="main-header__side-item user-menu">
		  <div class="user-menu__data">
		  	<?php echo "<p>" . $_SESSION['username'] . "</p>"; ?>
                        <a href="<?php echo SITE_ROOT . "/pages/logout.php"; ?>">Выйти</a>
		  </div>
		</div>
	<?php endif; ?>
</header>

