<?php
session_start();

//editprofile page
// author Elusoji Sodeeq
//Company EdgeProject

if (isset($_SESSION['loggedin']) AND $_SESSION['loggedin'] = true){
	
	try {
			include '../dbconnect.php';
			$sql = "SELECT firstname, lastname, email, password, phone FROM user WHERE 
				username = :username";
			$s = $pdo->prepare($sql);
			$s->bindParam(':username',$_SESSION['username']);
			$s->execute();
			$row = $s->fetch();

		}
		catch(PDOException $e){
			$output = "Oops! We are sorry, there's an error, please try later.";
			

		}

	if (isset($_POST['editprofile'])){

		$firstName = $_POST['firstname'];
		$lastName = $_POST['lastname'];
		$email = $_POST['email'];
		$password = $_POST['password'];
		$phone = $_POST['phone'];
		

		try{
			include "../dbconnect.php";
			$sql = "UPDATE user SET firstname = :firstname, 
				lastname = :lastname, email = :email, 
				password = :password,
				phone = :phone WHERE username = :username";
			$s = $pdo->prepare($sql);
			$s->bindParam(':username', $_SESSION['username']);
			$s->bindParam(':firstname', setDefault($firstName, $row['firstname']));
			$s->bindParam(':lastname', setDefault($lastName, $row['lastname']));
			$s->bindParam(':email', setDefault($email, $row['email']));
			$s->bindParam(':phone', setDefault($phone, $row['phone']));
			$s->bindParam(':password', md5(setDefault($password, $row['password'])));
			$s->execute();

			if ($s->rowCount() > 0){
				$output =  $_SESSION['username'] . ", your profile has been updated";
				
				$output .= "<p><a href='../profile'>Return to your profile</a></p> ";
			}
			else{
				$output =  "Nothing to update";
				
				$output.="<p><a href='../profile'>Return to your profile</a></p> ";

			}
		}
		catch(PDOException $e){
			exit();
		}
	}
	
}

else{
	header("Location:../login");
}	

function setDefault($valueToCheck,  $defaultValue){
	if (empty($valueToCheck)){
		$valueToCheck = $defaultValue;
	}
	return $valueToCheck;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>IRefer | <?php echo $_SESSION['username'] ?> - editprofile</title>
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

<?php   echo $_SESSION['username']; ?>
  
  <h3>Update your profile</h3>
  <form method="post" action="">

  	First Name:<input type="text" name="firstname" placeholder="firstname"
  	value="<?php echo $row['firstname']; ?>"/><br/>
  	Last Name: <input type="text" name="lastname" placeholder="lastname" 
  		value="<?php echo $row['lastname']; ?>"/><br />
  	Email: <input type="email" name="email" placeholder="your new email" 
  		value="<?php echo $row['email']; ?>"/><br/> 
  	Password: <input type="password" name="password" placeholder="new password" 
  		value="<?php echo $row['password']; ?>"/></br>
  	Phone: <input type="text" name="phone" placeholder="23480xxxxxxxxx"
  		value="<?php echo $row['phone']; ?> "/><br/>
  	<input type="submit" name="editprofile" value="save profile" /><br />
  </form>
<?php   include "../output.html.php"; ?>
  <div>
  	<a href="../profile">View profile</a>
  	<a href="../logout">Log out</a>
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

