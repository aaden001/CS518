<?php 
  	ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
	include 'dbconnect.php';	
	$like = 1;$dislike =0;

	if(isset($_POST['action'])){
		$post_id = $_POST['post_id'];
		$action = $_POST['action'];
		$user_id = $_POST['user_id'];
		switch ($action) {
			case 'like':
				# code...
			$SQL = "INSERT INTO ChatLikes(chatID,userRateID,rating) 
					VALUES ($post_id,$user_id,'like')
					ON DUPLICATE KEY UPDATE rating='like'";
				break;
			case 'dislike':
				# code...
			$SQL = "INSERT INTO ChatLikes(chatID,userRateID,rating) VALUES ($post_id,$user_id,'dislike') ON DUPLICATE KEY UPDATE rating='dislike'";
				break;
			case 'unlike':
				# code...
			$SQL = "DELETE FROM ChatLikes WHERE userRateID=$user_id AND chatID=$post_id";
				break;
			case 'undislike':
				# code...
			$SQL = "DELETE FROM ChatLikes WHERE userRateID=$user_id AND chatID=$post_id";
				break;
			default:
				# code...
				break;
		}

		$querry = $Connection->prepare($SQL);
		$querry->execute();

		echo getRating($post_id);
		$Connection = null;

	}
	 function getRating($tempID){
	 	include 'dbconnect.php';

	 	$rating = array();
	 	$likeSQL = "SELECT * FROM ChatLikes WHERE chatID = $tempID AND rating='like'";
	 	$dislikeSQL = "SELECT * FROM ChatLikes WHERE chatID = $tempID AND rating='dislike'";
	 	$likQuerry = $Connection->prepare($likeSQL);
	 	$likQuerry->execute();
	 	$dislikeQuerry= $Connection->prepare($dislikeSQL);
	 	$dislikeQuerry->execute();
	 	$likeCount = $likQuerry->rowCount();
	 	$dislikeCount = $dislikeQuerry->rowCount();

	 	$rating = [
	 		'likes' => $likeCount,
	 		'dislikes' =>$dislikeCount
	 	];
	 	return json_encode($rating);
	}

	function getusersLikes($tempID){
		include 'dbconnect.php';

		$likeSQL = "SELECT * FROM ChatLikes WHERE chatID = $tempID AND rating='like'";
		$likQuerry = $Connection->prepare($likeSQL);
		$likQuerry->execute();
		$likeCount = $likQuerry->rowCount();
		$Connection = null;
		return $likeCount;
	}

	function getusersDislikes($tempID){
		include 'dbconnect.php';

	 	$dislikeSQL = "SELECT * FROM ChatLikes WHERE chatID = $tempID AND rating='dislike'";
		$dislikeQuerry = $Connection->prepare($dislikeSQL);
		$dislikeQuerry->execute();
		$dislikeCount = $dislikeQuerry->rowCount();
		

		return $dislikeCount;
	}

	function userLiked($chatID,$userID){
	include 'dbconnect.php';

	$ChecklikedSQL = "SELECT * FROM ChatLikes WHERE chatID = $chatID AND userRateID=$userID AND rating='like'";
	$querryChecklikedSQL = $Connection->prepare($ChecklikedSQL);
	$querryChecklikedSQL->execute();
	
		if ($querryChecklikedSQL->rowCount() > 0) {
			return true;
		}else{
			return false;
		}


	}
	function userDisliked($chatID,$userID){
	include 'dbconnect.php';

	$CheckdislikedSQL = "SELECT * FROM ChatLikes WHERE chatID = $chatID AND userRateID=$userID AND rating='dislike'";
	$querryCheckdislikedSQL = $Connection->prepare($CheckdislikedSQL);
	$querryCheckdislikedSQL->execute();
	
		if ($querryCheckdislikedSQL->rowCount() > 0) {
			return true;
		}else{
			return false;
		}


	}

 ?>