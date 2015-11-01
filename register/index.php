<!DOCTYPE html>
<html>
	<head>
		<title>IRefer | Register your account</title>
	</head>
	<body>
<?php
// registration page
// author Elusoji Sodeeq
//Company EdgeProject
$firstName = "";
$lastName = "";
$email = "";
$username = "";
$password = "";
$output = "";

if (isset($_POST['register'])){
	$firstName = htmlspecialchars($_POST['firstname']);
	$lastName = htmlspecialchars($_POST['lastname']);
	$email = htmlspecialchars($_POST['email']);
	$username = htmlspecialchars($_POST['username']);
	$password = htmlspecialchars($_POST['password']);
	
	//checking if any of the fields is/are empty
	if (!empty($firstName) && !empty($lastName) && !empty($email)&& !empty($username)
		&& !empty($password)){

		try{
			include "../dbconnect.php";
			//first checking if the username already exists
			$sql = "SELECT * FROM user WHERE username = :username ";
			$s = $pdo->prepare($sql);
			$s->bindParam(':username', $username);
			$s->execute();
			$result = $s->fetch();

			if (count($result) > 1){
				$output = "Sorry, that username is not available.";
				include "../output.html.php";
			}
			else{
				$sql = "INSERT INTO user(firstname, lastname,
					email, username, password, referred) VALUES(:firstname, :lastname, 
					:email, :username, :password, 0)";
				$s = $pdo->prepare($sql);
				$s->bindParam(':firstname', $firstName);
				$s->bindParam(':lastname', $lastName);
				$s->bindParam(':email', $email);
				$s->bindParam(':username', $username);
				$s->bindParam(':password', md5($password));
				$s->execute();

				if ($s->rowCount() > 0){
					session_start();
					$_SESSION['loggedin'] = true;
					$_SESSION['username'] = $username;
					$_SESSION['newreg'] = true;
					header("Location:../profile");
				}
				else{
					$output = "There was an error while creating your account";
					include "../output.html.php";
				}
			}
		}
		catch(PDOException $e){
			$output = "Database error". $e->getMessage();
			include "../output.html.php";
		}
	}	
	else{
		$output = "Some of the fields were empty, please go back and fill them";
		include "../output.html.php";
	}


}
else{
	?>
	
			<form method="post" action="">
				<label for="FirstName">First Name:
					<input type="text" name="firstname" value="<?php echo $firstName ?>" />
				</label><br />
				<label for="LastName">Last Name:
					<input type="text" name="lastname" value="<?php echo $lastName ?>"/>
				</label></br>
				<label for="email">Email:
					<input type="email" name="email" placeholder="someone@example.com" 
						value="<?php echo $email ?>"/>
				</label></br>
				<label for="Username">Username:
					<input type="text" name="username" value="<?php echo $username ?>">
				</label><br/>
				<label for="email">Password:
					<input type="password" name="password" value="<?php echo $password ?>"/>
				</label></br>
				<input type="submit" name="register" value="Register">
				<br/>
			</form>
			<h3>Already have an account? 
				<a href="../login">Login</a>
			</h3>	
		
<?php
}
?>


	<body>
</html>