<?php
	function alert($msg) {
	    echo "<script type='text/javascript'>alert('$msg');</script>";
	}

	session_start();
	require('db.php'); 
	include($_SERVER['DOCUMENT_ROOT']."/todoer/config.php");
	if (isset($_SESSION["username"])){
		$user_id = $_SESSION['user_id'];
		$query    = "SELECT * FROM users WHERE id='$user_id'";
		$result = mysqli_query($con, $query) or die(mysqli_error($con));
		$row = $result->fetch_row();
		$time = strtotime($row[4]);
		if (date('Y-m-d') != date('Y-m-d', $time) ){
			$cdate = new DateTime('tomorrow');
			$cdate = $cdate->format('Y-m-d');
			$query    = "SELECT * FROM `tasks` WHERE author='$user_id' AND create_datetime='$cdate'";
			$result = mysqli_query($con, $query) or die(mysqli_error($con));
			$rows = mysqli_num_rows($result);
			if ($rows > 0){
				alert("У вас есть задачи на завтра!");
				$cdate = date('Y-m-d');
				$query = "UPDATE users SET last_notice='$cdate' WHERE id='$user_id'";
				$result = mysqli_query($con, $query) or die(mysqli_error($con));
			}
		}
	}
?>

<!DOCTYPE html>
<html lang="ru">
	<?php include($_SERVER['DOCUMENT_ROOT']."/todoer/blocks/includes.php"); ?>
	<body>
		<div class="page-wrapper">
			<div class="container container--with-sidebar">
				<?php include($_SERVER['DOCUMENT_ROOT']."/todoer/blocks/head.php"); ?>
				<?php
					if(!isset($_SESSION["username"])){
						include($_SERVER['DOCUMENT_ROOT']."/todoer/blocks/guest.php");
					}
					else{
						include($_SERVER['DOCUMENT_ROOT']."/todoer/blocks/main.php");
					}
				?>
			</div>
		</div>
		<?php include($_SERVER['DOCUMENT_ROOT']."/todoer/blocks/footer.php"); ?>
		<script src="flatpickr.js"></script>
		<script src="script.js"></script>
	</body>
</html>
