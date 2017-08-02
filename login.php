<?php
	require 'config.php';

	if(isset($_POST['login'])) {
		$errMsg = '';

		// Get data from FORM
		$username = $_POST['username'];
		$password = $_POST['password'];

		if($username == '')
			$errMsg = 'Enter username';
		if($password == '')
			$errMsg = 'Enter password';

		if($errMsg == '') {
			try {
				$stmt = $connect->prepare('SELECT id, fullname, username, password, email FROM pdo WHERE username = :username');
				$stmt->execute(array(
					':username' => $username
					));
				$data = $stmt->fetch(PDO::FETCH_ASSOC);

				if($data == false){
					$errMsg = "User $username not found.";
				}
				else {
					if($password == $data['password']) {
						$_SESSION['name'] = $data['fullname'];
						$_SESSION['username'] = $data['username'];
						$_SESSION['password'] = $data['password'];
						$_SESSION['ttl'] = $data['ttl'];
						$_SESSION['email'] = $data['email'];

						header('Location: dashboard.php');
						exit;
					}
					else
						$errMsg = 'Password not match.';
				}
			}
			catch(PDOException $e) {
				$errMsg = $e->getMessage();
			}
		}
	}
?>

<html>
<head>
	<title>Login</title>
	<link rel="stylesheet" href="css/style.css">
</head>
<body>
	<div class="nav">
			<a href="index.php"?><img src="img/pilkom.png"></a>
			<a href="login.php"?>| Login</a>
			<a href="register.php"?>|Sign Up</a>
			<a href="forgot.php">| Forgot Password</a>
	</div>
	<br>
	<?php
		if(isset($errMsg)){
			echo '<div class="errMsg">'.$errMsg.'</div>';
		}
	?>
	<hr>
	<div class="login"><h3>Login</h3></div>
	<div class="form-login">
		<form action="" method="post">
			<input type="text" name="username" value="<?php if(isset($_POST['username'])) echo $_POST['username'] ?>" autocomplete="off" class="box"/><br /><br />
			<input type="password" name="password" value="<?php if(isset($_POST['password'])) echo $_POST['password'] ?>" autocomplete="off" class="box" /><br/><br />
			<input type="submit" name='login' value="Login" class='submit'/><br />
		</form>
	</div>
	<hr>
</body>
</html>
