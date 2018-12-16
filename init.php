<?php
	session_start();
	//require_once 'vendor/jublonet/codebird-php/src/codebird.php';
	require_once 'vendor/autoload.php';
	require_once 'dbconnect.php';
	require_once 'TwitterAuth.php';
	\Codebird\Codebird::setConsumerKey('dKbBvndNgJFQQYVSAzmQfKFcS','owZENw37LnjdRsdtiMyIDYscXsJ1Dq36RoYDaVLJlqbrmAk8MW');
	$client = \Codebird\Codebird::getInstance();
	///var_dump($client);
?>
