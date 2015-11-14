<?php
	session_start();
//log in page
// author Elusoji Sodeeq
//Company EdgeProject
$output = "";
if (isset($_POST['login'])){
	if (!empty($_POST['username']) AND !empty($_POST['password'])){


		$username = htmlspecialchars($_POST['username']);
		$password = htmlspecialchars($_POST['password']);
	}
	else{
		$output = "You didn't fill out some information<br/>";
		
	}
	

	try{
		include "../dbconnect.php";
		$sql = "SELECT username, count(*) AS howmany FROM user WHERE username=:username
			AND password=:password";
		$s = $pdo->prepare($sql);
		$s->bindParam(':username', $username);
		$s->bindParam(':password', md5($password));
		$s->execute();
		$result = $s->fetch();
		if ($result['howmany'] == 1){
			
			$_SESSION['loggedin'] = true;
			$_SESSION['username'] = $username;
			header("Location:../profile");
		}
		else{
			$output =  "Incorrect username or password<br/>";
			
		}
	}
	catch(PDOException $e){
		exit();
	}
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>IRefer | Login</title>
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
		<form action="" method="post" id="form">
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
		<div>
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