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
	}elseif($_POST['roomId'] && $_POST['userId']){
			$roomId = $_POST['roomId'];
			$userId = $_POST['userId'];
			if($userId == 6){
				include 'roomClass.php';
				$rooObj = new Room();

				if($rooObj->check_room_status($roomId) == 1){
					if($rooObj->change_room_status($roomId, 0)){
						echo "0";
					}else{
						echo "error Occured";
					}
				}else{
					if($rooObj->change_room_status($roomId, 1)){
					echo "1";
					}else{
					echo "error Occured";
					}
				}

			}
	}



?>