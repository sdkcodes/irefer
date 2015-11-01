<?php
//dbconnection helper
// author Elusoji Sodeeq
//Company EdgeProject
try{
	$pdo = new PDO('mysql:host=localhost;dbname=refsystem', 'root', '');
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$pdo->exec('SET NAMES "utf8"');
}
catch(PDOException $e){
	echo "Unable to connect to database server. Please try later";
	exit();
}


?>