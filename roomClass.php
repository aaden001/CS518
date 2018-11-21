<?php 
	class Room{
		private $userId, $Id,$Name,$roomTyp;

		public function setUserId($tempUserId){
			$this->userId = $tempUserId;
		}
		public function setRoomId($tempRoomId){
			$this->Id =$tempRoomId;
		}
		public function setRoomTyp($tempTyp){
			$this->roomTyp = $tempTyp;
		}

		public function setRoomName($tempRoomName){
			$this->Name = $tempRoomName;
		}
		public function getUserId(){
			return $this->userId;
		}
		public function getRoomId(){
			return $this->Id;
		}
		public function getRoomName(){
			return $this->Name;
		}
		public function getRoomTyp(){
			return $this->roomTyp;
		}
		public function checkRoomDuplicate(){
			include 'dbconnect.php';
			$Sql = $Connection->prepare("SELECT Name FROM Rooms WHERE Name=:tempName");
			$Sql->execute(array('tempName' => $this->getRoomName()));
			if($Sql->rowCount() == 1){
				return false;
			}else{
				return true;
			}
			$Connection = null;
		}
		public function CreateNewRoom(){
			/*We want to be able to create a new room 
			and add the room creator to as admistrator of that room*/
			include 'dbconnect.php';
			include 'UserClass.php';

			///Rooms table auto increments
			$SqlAddNewRoom =  $Connection->prepare("INSERT INTO Rooms(Name,grpTyp) VALUES(:tempName, :tempRoomTyp)");
			$SqlAddNewRoom->execute(array('tempName' => $this->getRoomName(), 'tempRoomTyp' => $this->getRoomTyp()));

			$findRoom = $Connection->prepare("SELECT ID FROM Rooms WHERE Name=:tempName");
			$findRoom->execute(array('tempName' => $this->getRoomName()));
			
			$result = $findRoom->fetch();
			
			$this->setRoomId($result['ID']);
			
			$this->AddAdministrator(); ///Add room creator as an administrator 		
		}

		public function AddAdministrator(){
			include 'dbconnect.php';

			$sqlAdd = $Connection->prepare("INSERT INTO Administrators(UserID,RoomsID) VALUES (:tempUserId,:tempRoomId)");
			$sqlAdd->execute(array('tempUserId' => $this->getUserId(),'tempRoomId' => $this->getRoomId()));

			$Connection = null;
		}
		public function CheckAdminPrivilage($userID,$roomID){
			include 'dbconnect.php';
			 $querry = $Connection->prepare("SELECT * FROM Administrators WHERE UserID=:tempUserId AND RoomsID=:tempRoomId");
			 $querry->execute(array('tempUserId' => $userID, 'tempRoomId' =>$roomID));

			 if($querry->rowCount() == 0)
			{
				return false;

			}else{
				return true;
			}
				$Connection= null;	
		}
		public function sendInvitation(){
			/*construct a link based on the Administrator's Id 
			and the user the Administrator wants to send to 
			Store Admin ID, User_Id and link in data base
			*/
			include 'dbconnect.php';
			$Connection= null;	
		}
	}

 ?>