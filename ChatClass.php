<?php 
	/**
	 * 
	 */
	class Chat{
		private $Id, $roomID, $userID,$text, $timeStamp, $userHandle;

		public function setChatId($tempId){
			$this->Id = $tempId;

		}
		public function setRoomId($tempRoomId){
			$this->roomID = $tempRoomId;
		}
		public function setUserID($tempUserId){
			$this->userID = $tempUserId;
		}
		public function setText($tempText){
			$this->text = $tempText;
		}
		public function setTimeStamp($tempTimeStamp){
			$this->timeStamp = $tempTimeStamp;
		}
		public function setHandle($tempHandle){
			$this->userHandle = $tempHandle;
		}

		public function getChatId(){
			return $this->Id;
		}
		public function getRoomId(){
			return $this->roomID;
		}
		public function getUserId(){
			return $this->userID;
		}
		public function getText(){
			return $this->text;
		}
		public function getTimeStamp(){
			return $this->timeStamp;
		}
		public function getHandle(){
			return $this->userHandle;
		}
		///PreCheck
		public function matchCheck($userTempId,$currentRoomChatID){
			include "dbconnect.php";
			
			$sql = "SELECT * FROM UserGroups WHERE UserID=:usertemID AND RoomsID=:tempoRoomId ";
			$query = $Connection->prepare($sql);
			$query->execute(array('usertemID' =>$userTempId, 'tempoRoomId' => $currentRoomChatID));
			
			if($query->rowCount() == 0)
			{
				return false;

			}else{
				return true;
			}
				$Connection= null;	

		}
		///Insert Message
		                
		public function insertMessegeDB(){
			include "dbconnect.php";

			
			 $chatQuerry = $Connection->prepare("INSERT INTO ChatBox(RoomID,UserID,TextA) VALUES(:RoomIdent,:UserIdent, :ChatTextIdent)");
			 $chatQuerry->execute( array('RoomIdent' => $this->getRoomId(),
			 	'UserIdent' => $this->getUserId(),
				'ChatTextIdent' =>$this->getText()
 			));
		/*	 echo $this->getRoomId();*/
			// header("Location:GlobalRoom.php?currentRoomID=$this->getRoomId()");
			 $Connection = null;		
		}
	
		/// Display Messages
		public function displayChatMessage(){
			include "dbconnect.php";
		
			$currentRoomChatID = $_SESSION['currentRoomID'];
		 	$SQL ="SELECT created_at, TextA,userHandle FROM ChatBox INNER JOIN Users ON ChatBox.UserID = Users.userID WHERE RoomID=:roomIdentify ORDER BY ID";
			$query = $Connection->prepare($SQL);
			$query->execute(array('roomIdentify' => $currentRoomChatID));
			$count = $query->rowCount();
			/* Used for debugging

			$count = $query->rowCount();
			echo $count;
			$query->setFetchMode(PDO::FETCH_ASSOC);
			$result =$query->fetchAll();
			var_dump($result);
			echo $count;
			
			*/

			if($query->rowCount() > 0){

				while ($result = $query->fetch())
				{
					
					$this->setTimeStamp($result['created_at']);
					$this->setText($result['TextA']);
					$this->setHandle($result['userHandle']);
					
				
				} 
			}else{
				echo "Welcome to link, link with other people in the room by chatting <br>";
			}
			
		 	}
			
		}


 ?>