<form class="search-form" method="get" autocomplete="off">
    <input class="search-form__input" type="text" name="search" placeholder="Поиск по задачам" value="<?php echo $_GET['search'] ?? ''; ?>" >
    <input class="search-form__submit" type="submit" name="" value="Искать">
</form>

<div class="tasks-controls">
    <nav class="tasks-switch">
	<a href="<?php echo SITE.'/index.php?date=' ?>" class="tasks-switch__item <?php if (!isset($_GET['date']) or !$_GET['date']) echo 'tasks-switch__item--active'?>">Все задачи</a>
	<a href="<?php echo SITE.'/index.php?date=today' ?>" class="tasks-switch__item <?php if ($_GET['date'] == 'today') echo 'tasks-switch__item--active'?>">Повестка дня</a>
	<a href="<?php echo SITE.'/index.php?date=tomorrow' ?>"  class="tasks-switch__item <?php if ($_GET['date'] == 'tomorrow') echo 'tasks-switch__item--active'?>">Завтра</a>
	<a href="<?php echo SITE.'/index.php?date=past' ?>"  class="tasks-switch__item <?php if ($_GET['date'] == 'past') echo 'tasks-switch__item--active'?>">Просроченные</a>
    </nav>

    <label class="checkbox">
	<input class="checkbox__input visually-hidden show_completed" type="checkbox" <?php if ($_GET['show_completed']) echo "checked"; ?> >
	<span class="checkbox__text">Показывать выполненные</span>
    </label>
</div>
