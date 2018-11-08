<?php 
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);

	session_start();
	 if(!isset($_SESSION['userId']))
    {
        header("Location:index.php");
    }else

    
	include 'inviteClass.php';
	if(!empty($_POST['email']))
	{
		if(isset($_POST['email']))	
		{	

			require_once 'roomClass.php';
			$newRoom = new Room();
			$tempAdminID = $_SESSION['userId'];///need for user priveledges 
			$roomID =$_SESSION['currentRoomID'];
			if($newRoom->CheckAdminPrivilage($tempAdminID,$roomID)){
				$NewInvite  = new Invite();
				$Email = stripslashes(htmlspecialchars($_POST['email']));
				$NewInvite->setAdminID($tempAdminID);
				$NewInvite->setInvitedEmail($Email);
				$NewInvite->setRoomID($roomID);
				if($NewInvite->CheckEmail()){
					///send an Invited
					if($NewInvite->CheckForDoubleInvite($NewInvite->getAdminID(),$NewInvite->getInvitedID())){
					$NewInvite->SendInvite();	
					}
					
				}
				
			}else{
				header("Location:sendInvitation.php?error=14");
			}
		}
	}else{

		header("Location:sendInvitation.php?error=3");
	}

	/*
  error numbers meaning 
   Required takes case of this errors so no 
   submittion unless all field are completed
   1
   2 Full Name not inputed
   3 email not inputed 
   4 handle not inputed 
   5 password not inputed
   6 Confirmed password not inputed

     ///Definitely need this for important error handling
    7 password and Cpassword not matching 
    8 Email match to database
    9 Handle mathc to database
    10 Both Email and Handle to match to database
    11. empty group Name field
    12. Room duplicate
    13. Email Not In database
    14. Not an Administrator to send invite
    15. Admin cant invite themselve
    16.
    17.
    18.
*/
 ?>