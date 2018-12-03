<?php 
	require 'vendor/autoload.php';
	$authenticator = new PHPGangsta_GoogleAuthenticator();
	$secret = $authenticator->createSecret();
	echo "Secret: ".$secret;
 
?>
