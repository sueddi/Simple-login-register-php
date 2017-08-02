<?php
	require 'config.php';
	if(empty($_SESSION['name']))
		header('Location: login.php');

	if(isset($_POST['update'])) {
		$errMsg = '';

		$fullname = $_POST['fullname'];
		$ttl = $_POST['ttl'];
		$email = $_POST['email'];
		$password = $_POST['password'];
		$passwordVarify = $_POST['passwordVarify'];

		if($password != $passwordVarify)
			$errMsg = 'Password not matched.';

		if($errMsg == '') {
			try {
		      $sql = "UPDATE pdo SET fullname = :fullname, ttl = :ttl, password = :password, email = :email WHERE username = :username";
		      $stmt = $connect->prepare($sql);
		      $stmt->execute(array(
		        ':fullname' => $fullname,
			      ':ttl' => $ttl,
		        ':email' => $email,
		        ':password' => $password,
		        ':username' => $_SESSION['username']
		      ));
				header('Location: update.php?action=updated');
				exit;
			}
			catch(PDOException $e) {
				$errMsg = $e->getMessage();
			}
		}
	}

	if(isset($_POST['cancel'])) {
		header('Location: dashboard.php');
	}

	if(isset($_GET['action']) && $_GET['action'] == 'updated')
		$errMsg = 'Successfully updated. <a href="logout.php">Logout</a> and login to see update.';
?>

<html>
<head><title>Update</title>
<link rel="stylesheet" href="css/style.css">
</head>
<body>
	<div class="nav">
			<a href="dashboard.php"><img src="img/pilkom.png"></a>
			<a href="update.php">| <?php echo $_SESSION['name']; ?></a>
	</div>
	<br>
		<?php
			if(isset($errMsg)){
				echo '<div class="errMsg">'.$errMsg.'</div>';
			}
		?>
		<hr>
		<h3>Update Profil</h3>
		<div class="form">
			<form action="" method="post">
				<label for="">Name :</label><br>
				<input type="text" name="fullname" size="30" value="<?php echo $_SESSION['name']; ?>" autocomplete="off" class="box"/><br /><br />
				<label for="">Username :</label><br>
				<input type="text" name="username" size="30" value="<?php echo $_SESSION['username']; ?>" disabled autocomplete="off" class="box"/><br /><br />
				<label for="">Birth Date :</label><br>
				<input type="date" name="ttl" size="30" value="<?php echo $_SESSION['ttl']; ?>" autocomplete="off" class="box"/><br /><br />
				<label for="">Email :</label><br>
				<input type="text" name="email" size="30" value="<?php echo $_SESSION['email']; ?>" autocomplete="off" class="box"/><br /><br />
				<label for="">Password :</label><br>
				<input type="password" name="password" size="30" value="<?php echo $_SESSION['password'] ?>" class="box" /><br/><br />
				<label for="">Password Varify :</label><br>
				<input type="password" name="passwordVarify" size="30" value="<?php echo $_SESSION['password'] ?>" class="box" /><br/><br />
        <input type="submit" name='update' value="Update" class='submit'/>
				<input type="submit" name="cancel" value="cancel"><br>
			</form>
		</div>
		<hr>
	</div>
</body>
</html>
