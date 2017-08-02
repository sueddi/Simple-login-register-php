<?php
	require 'config.php';
	try {
	    $handler = new PDO('mysql:host=localhost;dbname=pdo','root', '');
	    $handler->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	} catch (PDOException $e){
	    exit($e->getMessage());
	}

	if(isset($_POST['register'])) {
		$errMsg = '';
		$existsMsg = '';


		// Get data from FROM
		$fullname = $_POST['fullname'];
		$username = $_POST['username'];
		$ttl = $_POST['ttl'];
		$password = $_POST['password'];
		$email = $_POST['email'];

		if($fullname == ''){
			$errMsg = 'Enter your name';
		}

		if($fullname == !preg_match("/^[a-zA-Z ]*$/",$fullname)) {
	     $errMsg = "Only letters and white space allowed";
   	}

		if($username == ''){
			$errMsg = 'Enter username';
		}

		if(substr($username,0,2) >= '16'){
			$errMsg = 'Maba can not register yet';
		}

		if(substr($username,3,2) != '15'){
			$errMsg = 'Sorry, Only filkom student can register';
		}

		if($username == !is_numeric($username)){
			$errMsg = 'nim username must be a number';
		}

		if(strlen($username) != 15){
			$errMsg = "nim must equals 15 digit";
		}

		if($ttl == ''){
			$errMsg = 'Enter your birth';

		}
		if($password == ''){
			$errMsg = 'Enter password';
		}

		if(strlen($password) < 6 && $password >16){
			$errMsg = "Password must be atleast 6-16 characters";
		}

		if($email == ''){
			$errMsg = 'Enter email';
		}

		if(!filter_var($email, FILTER_VALIDATE_EMAIL))	{
	    $errMsg = 'Please enter a valid email address !';
		}

		if($ttl >= date("Y-m-d")){
	    $errMsg = 'You cannot enter a date in the future!';
		}

		if (!preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$ttl)){
				$errMsg = 'entry date appropriate format!';
		}


		if($errMsg == ''){
			$sthandler = $handler->prepare("SELECT username FROM pdo WHERE username = :username");
			$ethandler = $handler->prepare("SELECT email FROM pdo WHERE email = :email");
			$sthandler->bindParam(':username', $username);
			$ethandler->bindParam(':email', $email);
			$sthandler->execute();
			$ethandler->execute();

			if($sthandler->rowCount() > 0){
			    $errMsg = "nim already exists!<br>";
					if($ethandler->rowCount() > 0){
						$errMsg = "email already exists";
					}
			}else if($ethandler->rowCount() > 0){
				$errMsg = "email already exists";
			}else{
				try {
					$stmt = $connect->prepare('INSERT INTO pdo (fullname, username, ttl, password, email) VALUES (:fullname, :username, :ttl, :password, :email)');
					$stmt->execute(array(
						':fullname' => $fullname,
						':username' => $username,
						':ttl' => $ttl,
						':password' => $password,
						':email' => $email
						));
					header('Location: register.php?action=joined');
				}
				catch(PDOException $e) {
					echo $e->getMessage();
				}
			}
		}
	}

	if(isset($_GET['action']) && $_GET['action'] == 'joined') {
		$errMsg = 'Registration successfull. Now you can <a href="login.php">login</a>';
	}
?>


<html>
<head><title>Register</title>
<link rel="stylesheet" href="css/style.css">
</head>
<body>
	<div class="nav">
			<a href="index.php"><img src="img/pilkom.png"></a>
			<a href="login.php">| Login</a>
			<a href="register.php">| Sign Up</a>
	</div>
		<?php
			if(isset($errMsg)){
				echo '<div class="errMsg">'.$errMsg.'</div>';
			}
		?>
		<br>
		<div class="h3"><h3>REGISTER</h3></div>
		<div class="form-register">
			<form name = "datadiri" action="" method="post">
				<label for="">Name : </label><br>
				<input type="text" name="fullname" size="30" value="<?php if(isset($_POST['fullname'])) echo $_POST['fullname'] ?>" class="box"/><br /><br />
				<label for="">Nim : </label><br>
				<input type="text" name="username" size="30" value="<?php if(isset($_POST['username'])) echo $_POST['username'] ?>" class="box"/><br /><br />
				<label for="">Birth Date : </label><br>
				<input type="date" name="ttl" size="30" required pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}" placeholder="[yy-mm-dd]" value="<?php if(isset($_POST['ttl'])) echo $_POST['ttl'] ?>" class="box"/><br /><br />
				<label for="">Password : </label><br>
				<input type="password" name="password" size="30" value="<?php if(isset($_POST['password'])) echo $_POST['password'] ?>" class="box" /><br/><br />
				<label for="">Email : </label><br>
				<input type="text" name="email" size="30" value="<?php if(isset($_POST['email'])) echo $_POST['email'] ?>" autocomplete="off" class="box"/><br /><br />
				<input type="submit" name='register' value="Register" class='submit'/><br />
			</form>
		</div>
</body>
</html>
