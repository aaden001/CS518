<?php 
	ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    include 'dbconnect.php';
    if(isset($_POST['text'])){
    	include 'commentClass.php';
    	$text = stripslashes(htmlspecialchars($_POST['text']));
    	$chatBox_id = $_POST['chatBox_id'];
    	$userId = $_POST['userId'];
    	$thread = 1;

    	echo $userId;

    	$newComment = new Comment();
    	$newComment->setCommentChatBoxId($chatBox_id);
    	$newComment->setCommentUserId($userId);
    	$newComment->setCommentTextAre($text);
    	$newComment->setCommentThread($thread);
    	$newComment->insertIncomment();
    }



 ?>