<?php 
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);

	session_start();
	 if(!isset($_SESSION['userId'])){
		header("Location:index.php");
	}else

		$hots_ID = $_GET['adminID'];
		$invited_ID = $_GET['userId'];
		$roomID = $_GET['roomID'];
		$choice = $_GET['accept'];


		if(isset($hots_ID) && isset($invited_ID) && isset($roomID) && isset($choice)){
			include 'inviteClass.php';
			$NetGetInvite =  new Invite();	

			$NetGetInvite->setAdminID($hots_ID);
			$NetGetInvite->setInviteID($invited_ID);
			$NetGetInvite->setRoomID($roomID);

			if($NetGetInvite->checkInvitation($NetGetInvite->getAdminID(),$NetGetInvite->getInvitedID(),$NetGetInvite->getRoomID())){

			if($choice == 1){
			require_once 'UserClass.php';   ///Add room creator as a user of the group
			$newusergroup = new User();
			$newusergroup->AddUserToRoom($NetGetInvite->getInvitedID(),$NetGetInvite->getRoomID());
			$NetGetInvite->UpdateFlagViewed();
			 echo "you have Accepted the request";
			 header("Refresh:3; url=Welcome.php",true, 303);
			}else{
				echo " You have denied the the request";
				$NetGetInvite->UpdateFlagViewed();
				header("Refresh:3; url=Welcome.php",true, 303);
			}

			}else{
			header("Location:Welcome.php?error=17");
			}

		}
		

 ?>