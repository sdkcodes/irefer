<?php
session_start();

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
					
					$_SESSION['loggedin'] = true;
					$_SESSION['username'] = $username;
					$_SESSION['newreg'] = true;
					header("Location:../profile");
				}
				else{
					$output = "There was an error while creating your account";
					
				}
			}
		}
		catch(PDOException $e){
			$output = "Database error". $e->getMessage();
			exit();
		}
	}	
	else{
		$output = "Some of the fields were empty, please go back and fill them";
		
	}


}

?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>IRefer | Register</title>
<meta charset="utf-8">
<meta name = "format-detection" content = "telephone=no" />
<link rel="icon" href="../images/favicon.ico">
<link rel="shortcut icon" href="../images/favicon.ico" />
<link rel="stylesheet" href="../css/desktop.css " >
<!--<link rel="stylesheet" href="../css/handheld.css ">
-->
<link rel="stylesheet" href="../css/form.css">

</head>

<body>
  <header>
    <div class="menubar1">
      <div class="img"><img src="../images/projecticon.gif" alt="Edgeproject" /></div>
      <a href="../">IRefer</a>
      <a href="http://blog.edgeproject.net">Blog</a>
    </div>
  </header>

  	<div>
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
  	<?php include "../output.html.php"; ?>
  	</div>

	<footer><div id="footer">
     <a href="http://facebook.com/teamedgeproject" name="fbConnect">
      <img src="../images/fbIcon.gif" alt="fbConnect" width="40" height="40" /></a> 
     <a href="http://twitter.com/teamedgeproject" name="twtConnect">
      <img src="../images/twtIcon.gif" alt="twtConnect" width="40" height="40" /></a>
     <br />
     &copy; 2015 EDGE PROJECT&trade;</div></footer>


</body>
</html>

