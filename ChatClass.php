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

			 $Connection = null;	
			 return $chatQuerry;	
		}
        public function deletePost(){
            include 'dbconnect.php';
            $qurry = $Connection->prepare('DELETE FROM ChatBox WHERE ID=:temp');
            $qurry->execute(array('temp' => $this->getChatId()));

            return $qurry;
        }
	}
        


 ?>