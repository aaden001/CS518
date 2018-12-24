<?php
	
	$Servername = "localhost";
	$Username = "root";
	$Password = "";
	$Database = "Chat";
/*
	///connect to database
	$Connection = new mysqli($Servername, $Username, $Password, $Database);
s

	if($Connection -> connect_error)
	{
		die("Failed to establish connection to MYSQL");
	}else{echo "Connection established ";}
	*/
	try{
		$Connection = new PDO("mysql:host=$Servername;dbname=$Database",$Username,$Password, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8") );
		$Connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		
		// echo  "Connection established ";
	}catch(Exception $e){
		die("Failed to establish connection to MYSQL: " .$e->getMessage());
	}
	
?> 
