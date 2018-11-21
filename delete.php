<?php 
	

	if($_POST['userId'] &&$_POST['postId']){ ///used to delete post
		$userId = $_POST['userId']; /*administrator id*/
		$postIdDell = $_POST['postId'];

		if ($userId == 6){
			include_once 'ChatClass.php';
			$DelChat = new Chat();
			$DelChat->setChatId($postIdDell);
			if($DelChat->deletePost() ){
				$out ="success";
			}else{
				$out .="error";
			}
			echo $out;
		}else{
			echo "You can not perform this not an admin";
		}
	}



?>