<?php

	$servername = "<servername>";
	$username = "<username>";
	$password = "<password>";
	$db = "attendance";
	
	try {
		$conn = new PDO("mysql:host=$servername;dbname=$db", $username, $password);
		$conn->exec("set names utf8");
    }
	catch(PDOException $e)
	{
		echo $e->getMessage();
	}
?>