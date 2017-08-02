<html>
<head><title>PDO MySQL</title>
<link rel="stylesheet" href="css/style.css">
</head>
<body>
		<?php
			if(isset($errMsg)){
				echo '<div class="errMsg">'.$errMsg.'</div>';
			}
		?>
		<div class="nav">
				<a href="index.php"?><img src="img/pilkom.png"></a>
				<a href="login.php"?>| Login</a>
				<a href="register.php">| Sign Up</a>
		</div>
		<?php include 'news.php' ?>
		<?php include 'footer.php' ?>
</body>
</html>
