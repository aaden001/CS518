<?php
	ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
	require_once 'init.php';
	
	$auth = new TwitterAuth($client);  ///this is taken to TwitterAuth.php
	$auth->getAuthUrl();

	if($auth->signedIn()){

      
		echo "<p>You are signed In</p>";
	}else{
		echo '<p><a href="' .$auth->getAuthUrl() .'">Sigin with Twitter</a></p>';
	}	

?>