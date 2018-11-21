<?php 

class Comment{
		private $id, $chatBoxID , $userId, $textArea, $timeStamp, $thread;

		public function setCommentId($temp){
			$this->id = $temp;
		}
		public function setCommentChatBoxId ($temp){
			$this->chatBoxID = $temp;
		}
		public function setCommentUserId($temp){
			$this->userId = $temp;
		}
		public function setCommentTextAre($value){
			$this->textArea = $value;
		}
		public function setCommetTimeStamp($value){
			$this->timeStamp = $value;
		}
		public function setCommentThread($tempthread){
			$this->thread = $tempthread;
		}


		public function getCommentUserId(){
			return $this->userId;
		}
		public function getCommentId(){
			return $this->id;
		}
		public function getCommentChatBoxId (){
			return $this->chatBoxID;
		}
		public function getCommentTextAre(){
			return $this->textArea;
		}
		public function getCommetTimeStamp(){
			return $this->timeStamp;
		}
		public function getCommentThread(){
			return $this->thread;
		}

		public function insertIncomment(){
			include 'dbconnect.php';

			$sql = $Connection->prepare("INSERT INTO Comment(ChatBoxID,userId,TextArea,thread) VALUES(:tempChat,:tempUserId,:tempText,:tempthread)");
			$sql->execute(array('tempChat' => $this->getCommentChatBoxId(),'tempUserId' => $this->getCommentUserId(),'tempText' => $this->getCommentTextAre(), 'tempthread' => $this->getCommentThread()));

			$Connection = null;
		}

		/*public function displayComment($chatBoxId, $thred){
			include 'dbconnect.php';
			$sql = $Connection->prepare("SELECT * ");
		}*/

}

 ?>