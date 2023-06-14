<?php
	$home = "http://localhost/todoapp";
?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <title>Дела в порядке</title>
    <?php
    	echo '<link rel="stylesheet" href="'.$home.'/css/normalize.css">';
    	echo '<link rel="stylesheet" href="'.$home.'/css/style.css">';
	echo '<link rel="stylesheet" href="'.$home.'/css/flatpickr.min.css">';
    ?>
</head>

<body>
	<div class="page-wrapper">
    		<div class="container container--with-sidebar">
			<?php echo $header ?>
			<div class="content">
				<?php echo $content ?>
			</div>
		</div>
      	</div>
	<?php echo $footer ?>
	<script src="<?php echo $home . "/flatpickr.js"?>"></script>
	<script src="<?php echo $home . "/script.js"?>"></script>
</body>
</html>
