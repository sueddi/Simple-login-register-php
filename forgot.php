<?php
	require 'config.php';

	if(isset($_POST['forgotpass'])) {
		$errMsg = '';

		// Getting data from FROM
		$email = $_POST['email'];

		if(empty($email))
			$errMsg = 'Please enter your email to view your password.';

		if($errMsg == '') {
			try {
				$stmt = $connect->prepare('SELECT password, email FROM pdo WHERE email = :email');
				$stmt->execute(array(
					':email' => $email
					));
				$data = $stmt->fetch(PDO::FETCH_ASSOC);
				if($email == $data['email']) {
					$viewpass = 'Your password is: ' . $data['password'] . '<br><a href="login.php">Login Now</a>';
				}
				else {
					$errMsg = 'email not matched.';
				}
			}
			catch(PDOException $e) {
				$errMsg = $e->getMessage();
			}
		}
	}
?>

<html>
<head><title>Forgot Password</title>
	<link rel="stylesheet" href="css/style.css">
</head>
<body>
	<div class="nav">
			<a href="index.php"><img src="img/pilkom.png"></a>
			<a href="login.php">| Login</a>
			<a href="register.php">| Register</a>
	</div>
	<div class="forgot-password">
		<br>
			<?php
				if(isset($errMsg)){
					echo '<div class="errMsg">'.$errMsg.'</div>';
				}
			?>
			<div class="forgot"><h3>Forgot Password</h3></div>
			<?php
				if(isset($viewpass)){
					echo '<div class="viewpass">'.$viewpass.'</div>';
				}
			?>
			<hr>
			<div class="form">
				<form action="" method="post">
					<input type="text" name="email" placeholder="Email" autocomplete="off" class="box"/><br /><br />
					<input type="submit" name='forgotpass' value="Check" class='submit'/><br />
				</form>
			</div>
			<hr>
	</div>
</body>
</html>
