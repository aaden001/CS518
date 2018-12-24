<?php
	
	
	//require_once 'vendor/jublonet/codebird-php/src/codebird.php';
	include ('vendor/autoload.php');
	//require_once 'dbconnect.php';
	include ('TwitterAuth.php');
	\Codebird\Codebird::setConsumerKey('PLc68WLvxnkG24zoVuhQKZMzr','XTAuGCw1uMWktSiwMYEgMDGhRFj90Ewalw80XQGymfXgV8mYst');
	$client = \Codebird\Codebird::getInstance();
	///var_dump($client);
?>
