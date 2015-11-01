<?php
session_start();
?>
<!DOCTYPE html>
<html>
	<head>
		<title>IRefer | <?php echo $_SESSION['username'] ?> - editprofile</title>
	</head>
	<body>
<?php
//editprofile page
// author Elusoji Sodeeq
//Company EdgeProject

if (isset($_SESSION['loggedin']) AND $_SESSION['loggedin'] = true){
	
	try {
			include '../dbconnect.php';
			$sql = "SELECT firstname, lastname, email, password FROM user WHERE 
				username = :username";
			$s = $pdo->prepare($sql);
			$s->bindParam(':username',$_SESSION['username']);
			$s->execute();
			$row = $s->fetch();

		}
		catch(PDOException $e){
			$output = "Oops! We are sorry, there's an error, please try later.";
			include "../output.html.php";

		}

	if (isset($_POST['editprofile'])){

		$firstName = $_POST['firstname'];
		$lastName = $_POST['lastname'];
		$email = $_POST['email'];
		$password = $_POST['password'];
		

		
		
		
	

		try{
			include "../dbconnect.php";
			$sql = "UPDATE user SET firstname = :firstname, 
				lastname = :lastname, email = :email, 
				password = :password WHERE username = :username";
			$s = $pdo->prepare($sql);
			$s->bindParam(':username', $_SESSION['username']);
			$s->bindParam(':firstname', setDefault($firstName, $row['firstname']));
			$s->bindParam(':lastname', setDefault($lastName, $row['lastname']));
			$s->bindParam(':email', setDefault($email, $row['email']));
			$s->bindParam(':password', md5(setDefault($password, $row['password'])));
			$s->execute();

			if ($s->rowCount() > 0){
				$output =  $_SESSION['username'] . ", your profile has been updated";
				include '../output.html.php';
				echo "<p><a href='../profile'>Return to your profile</a></p> ";
			}
			else{
				$output =  "Nothing to update";
				include '../output.html.php';
			}
		}
		catch(PDOException $e){
			echo $e->getMessage();
		}
	}
	else{
		echo $_SESSION['username'];
		?>
		
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
			<input type="submit" name="editprofile" value="save profile" /><br />
		</form>
		<?php
}
}

else{
	header("Location:../login");
}	

?>

	<body>
</html>
<?php
function setDefault($valueToCheck,  $defaultValue){
	if (empty($valueToCheck)){
		$valueToCheck = $defaultValue;
	}
	return $valueToCheck;
}
?>