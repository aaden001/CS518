<?php 
	
	class Invite{
		private $adminId, $invitedID, $roomId,$invitedEmail;

		public function setAdminID($tempAdmin)
		{
			$this->adminId = $tempAdmin;
		}
		public function setInviteID($value)
		{
			# code...
			$this->invitedID = $value;
		}
		public function setRoomID($value)
		{
			# code...
			$this->roomId = $value;
		}
		public function setInvitedEmail($value)
		{
			$this->invitedEmail = $value;
		}
		public function getAdminID()
		{
			# code...
			return $this->adminId;
		}
		public function getInvitedID()
		{
			# code...
			return $this->invitedID;
		}
		public function getRoomID()
		{
			return $this->roomId;
			# code...
		}
		
		public function getInvitedEmail(){
			return $this->invitedEmail;
		}



		public function checkInvitation($adimID,$inviteeId,$roomid){

			/*This function checks if there is really an invitation waiting for the invitee
			Use The Admin ID Inviteed_ID and flags
			*/
			include 'dbconnect.php';
			$flag = 0;
			$Sql =$Connection->prepare("SELECT * FROM InviteLinks WHERE AdminID=:tempAdminID AND userID=:tempUserId AND flag=:tempFlag AND RoomID=:tempRoomID");
			$Sql->execute(array('tempAdminID' => $adimID, 'tempUserId' => $inviteeId , 'tempFlag' => $flag, 'tempRoomID' => $roomid));
			if($Sql->rowCount() > 0){
				return true;
			}else{
				return false;
			}
			$Connection = null;
		}
		public function  UpdateFlagViewed(){
			/*This updates the flag in the database once notification has been clicked to join or not to join*/
			include 'dbconnect.php';
			$Changeflag = 1; $flag =0;
			$Sql = $Connection->prepare("UPDATE InviteLinks SET flag =:Flag WHERE AdminID=:tempAdminID AND userID=:tempUserId AND flag=:tempFlag AND RoomID=:tempRoomID");
			$Sql->execute(array('Flag' => $Changeflag, 'tempAdminID' => $this->getAdminID(), 'tempUserId' => $this->getInvitedID(), 'tempFlag' => $flag,'tempRoomID' => $this->getRoomID()));
			$Connection = null;
		}
		public function SendInvite(){
			/*To send em
			Admin Id 
			User Id 
			A Link
			A Flag 0 or 1
			*/
			include 'dbconnect.php';
			$link = "getInvite.php?adminID=" .$this->getAdminID() ."&userId=" .$this->getInvitedID();
			$flag = 0;
			$Sql = $Connection->prepare("INSERT INTO InviteLinks(AdminID,userID,RoomID,link,flag) VALUES(:tempAdminID,:tempInVitee,:tempRoomId,:link,:flag)");
			$Sql->execute(array('tempAdminID' => $this->getAdminID(),'tempInVitee' => $this->getInvitedID(),'tempRoomId' => $this->getRoomID(),'link' => $link, 'flag' => $flag));
			$Connection = null;
			echo "Invitation succesfully sent";
			header("Refresh:5; url=Welcome.php",true, 303);

		}
		
		public function CheckForDoubleInvite($adminId,$inviteeID,$room){
			/*From A specific admin to user*/
			include 'dbconnect.php';
			$flag = 0; /*Checking that notification is not sent again unless wghen used*/
			$Sql = $Connection->prepare("SELECT * FROM InviteLinks WHERE AdminID=:tempAdmin AND userID=:tempUserID AND RoomID=:tempRoom AND flag=:tempFlag");
			$Sql->execute(array('tempAdmin' => $adminId, 'tempUserID' => $inviteeID, 'tempRoom' => $room,'tempFlag' => $flag));
			if($Sql->rowCount() == 1)
			{
			header("Location:sendInvitation.php?error=16&currentRoomID=".$this->getRoomID());
			return false;
			}else{
				return true;
			}
			$Connection = null;
		}
		public function CheckEmail(){
			include 'dbconnect.php';

		$Sql =$Connection->prepare("SELECT userEmail,userId FROM Users WHERE userEmail=:tempUserMail");
			$NotAdmin= $Connection->prepare("SELECT userEmail FROM Users WHERE userId=:tempUserID");
			$NotAdmin->execute(array('tempUserID' => $this->getAdminID()));
		$Sql->execute(array('tempUserMail' => $this->getInvitedEmail()));
		$result = $Sql->fetch();
		$resultAdmin = $NotAdmin->fetch();
		$AdminEmail = $resultAdmin['userEmail'];
		$email = $result['userEmail'];
		$this->setInviteID($result['userId']);

		
		if($Sql->rowCount() == 0)
		{
			header("Location:sendInvitation.php?error=13&currentRoomID=".$this->getRoomID());
			return false;
		}else{
			if($AdminEmail != $email || $AdminEmail == "aaden001@odu.edu"){
				
			return true;
			}else{
				
				header("Location:sendInvitation.php?error=15&currentRoomID=".$this->getRoomID());
				return false;
			}
		}

		 
		
		$Connection = null;
		}
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
    16. Admin cant send invite to user he has sent to before
    17.
    18.
*/
 ?>