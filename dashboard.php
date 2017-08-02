<?php
	require 'config.php';
	if(empty($_SESSION['name']))
		header('Location: login.php');
?>

<html>
<head>
	<title>Dashboard</title>
	<link rel="stylesheet" href="css/style.css">
</head>
<body>
	<div class="nav"">
		<a href="dashboard.php"><img src="img/pilkom.png"></a>
		<a href="update.php">| Hi' <?php echo $_SESSION['name']; ?></a>
		<a href="logout.php" >| Logout</a>
		<?php
			if(isset($errMsg)){
				echo '<div class="errMsg">'.$errMsg.'</div>';
			}
		?>
	</div>
	<div class="isi">
		<?php
		include 'news.php';?>
	</div>

</body>
</html>

<?php include 'footer.php' ?>
