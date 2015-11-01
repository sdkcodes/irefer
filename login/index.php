<?php
//log in page
// author Elusoji Sodeeq
//Company EdgeProject
if (!isset($_POST['login'])){
	?>
	<!DOCTYPE html>
	<html lang="en">
		<head>
			<title>IRefer | Login</title>
		</head>
		<body>
			<form action="" method="post">
			<label for="Username">Username:
				<input type="text" name="username">
			</label></br>
			<label for="password">Password:
				<input type="password" name="password">
			</label></br>
			<input type="submit" name="login" value="Login"></br>
			</form>
			<h3>Don't have an account? 
				<a href="../register">Sign up</a>
			</h3>
		
<?php
}
else{
	if (!empty($_POST['username']) && !empty($_POST['password'])){


		$username = htmlspecialchars($_POST['username']);
		$password = htmlspecialchars($_POST['password']);
	}
	else{
		$output = "empty field";
		include "../output.html.php";
	}
	

	try{
		include "../dbconnect.php";
		$sql = "SELECT * FROM user WHERE username=:username
			AND password=:password";
		$s = $pdo->prepare($sql);
		$s->bindParam(':username', $username);
		$s->bindParam(':password', md5($password));
		$s->execute();
		$result = $s->fetch();
		if (count($result)  == 1){
			session_start();
			$_SESSION['loggedin'] = true;
			$_SESSION['username'] = $username;
			header("Location:../profile");
		}
		else{
			$output =  "Sorry, this account does not exist";
			include "../output.html.php";
		}
	}
	catch(PDOException $e){
		echo $e->getMessage();
	}
}
?>
	</body>
</html>