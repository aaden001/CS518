<?php
	
	
	//require_once 'vendor/jublonet/codebird-php/src/codebird.php';
	//require_once __DIR__ .'/vendor/autoload.php';
	echo shell_exec('pwd');
	
	//echo shell_exec("rm -rf vendor");
	
	///echo shell_exec("php composer.phar install");
	
	echo shell_exec('ls vendor/jublonet/codebirdphp/src/');
	require_once __DIR__ .'/vendor/autoload.php';
	require_once 'TwitterAuth.php';
	\Codebird\Codebird::setConsumerKey('PLc68WLvxnkG24zoVuhQKZMzr','XTAuGCw1uMWktSiwMYEgMDGhRFj90Ewalw80XQGymfXgV8mYst');
	$client = \Codebird\Codebird::getInstance();
	/*if(require_once '../vendor/autoload.php'){
		
	}else
	echo 'Not found';*/
	
	
	//require_once __DIR__ .'/vendor/codebird.php';
	//require_once 'dbconnect.php';
	
	///var_dump($client);
?>
