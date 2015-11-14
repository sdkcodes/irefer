<?php
session_start();

//user profile
// author Elusoji Sodeeq
//Company EdgeProject

if (isset($_SESSION['username']) AND $_SESSION['username'] != ""){

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
	?>
	<!DOCTYPE html>
	<html lang="en">
	<head>
	<title>IRefer | <?php $_SESSION['username'] ?></title>
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
<?php
	try{
		include "../dbconnect.php";
		$sql = "SELECT * FROM user WHERE username = :username";
		$s = $pdo->prepare($sql);
		$s->bindParam(':username', $_SESSION['username'] );
		$s->execute();
		$result = $s->fetch();
		
		if (!count($result) > 1){
			header("Location:../login");
		}
		else{
			
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
	}
	catch(PDOException $e){
	
	}
}
else{
	header("Location:../login");
}

?>

	<footer><div id="footer">
     <a href="http://facebook.com/teamedgeproject" name="fbConnect">
      <img src="../images/fbIcon.gif" alt="fbConnect" width="40" height="40" /></a> 
     <a href="http://twitter.com/teamedgeproject" name="twtConnect">
      <img src="../images/twtIcon.gif" alt="twtConnect" width="40" height="40" /></a>
     <br />
     &copy; 2015 EDGE PROJECT&trade;</div></footer>


</body>
</html>