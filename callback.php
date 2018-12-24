<?php
	 session_start(); 
	require_once 'init.php';
	$auth = new TwitterAuth($client);


	if($auth->signIn())
	{
		//header('Location: sample.php');
	}else{
		die('Sigin in failed');
	}
?>
