<?php
//user profile
// author Elusoji Sodeeq
//Company EdgeProject
session_start();
//if the user just created their account, execute this if statement
if (isset($_SESSION['newreg']) AND  $_SESSION['newreg'] == true){
	$output = "Your new account has been created, you can update your profile at any time.";
	?>
	<script>
		alert("<?php echo $output ?>");
	</script>
	<?php
	$_SESSION['newreg'] = false;
}
if (isset($_SESSION['username']) AND $_SESSION['username'] != ""){
	try{
		include "../dbconnect.php";
		$sql = "SELECT * FROM user WHERE username = :username";
		$s = $pdo->prepare($sql);
		$s->bindParam(':username', $_SESSION['username'] );
		$s->execute();
		$result = $s->fetch();
		
		if (count($result) > 1){
			echo "Welcome " . ucfirst($result['firstname']) ." " . ucfirst($result['lastname']);
			//echo "<br> You have referred " . " " . $result['referred'] . " people"; 
			echo "<br>";
			if ($result['referred'] < 1){
				$output = "You haven't referred anybody. 
					Start talking to your friends now to earn your cash";
					include "../output.html.php";
			}
			else{
				$output = "You have referred " .  $result['referred'] ." people";
				include "../output.html.php";
			}
			echo "<div> <hr>";
			echo "Your username (which is also your referral code) is " . $result['username'];
			echo "</div>";

			echo "<a href='../editprofile'>Edit profile</a>  ";
			echo " <a href='../logout'>Log out</a>";
		}
		else{
			header("Location:../login");
		}
	}
	catch(PDOException $e){
	
	}
}
else{
	header("Location:../login");
}

?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>IRefer | <?php echo $_SESSION['username']; ?></title>
	</head>
</html>