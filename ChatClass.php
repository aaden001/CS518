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
	}




/*		public function getRecentlySentMessage(){
			include 'dbconnect.php';
			$recentChat = $Connection->prepare("SELECT");

		}
	
public function sql_fecth_post($maxpostsize,$currentRoomChatID,$currentPage){
          //Querry for text,user handle and time stamp
     // $currentRoomChatID = $_SESSION['currentRoomID'];
     //   $currentPage = $_SESSION['currentPage'];
   //

        $StopCheck = $maxpostsize % 5;
        $Stop = 5;
    
        switch ($StopCheck) {
            case 0:
                
                if ($currentPage == 1){
                $Start = 0;
                }else{
                $Start = ($currentPage - 1)* 5;         
                }
            break;

            case 1:
                
                if ($currentPage == 1){
                $Start = 0;
                $Stop = $StopCheck; ///equals to 1
                }else{

                    
                $Start = (($currentPage -1)*5) - 4;
                $Stop = 5;
                }
            break;

            case 2:
                if ($currentPage == 1){
                $Start = 0;
                $Stop = $StopCheck; ///equals to 1
                }else{

                    
                $Start = (($currentPage -1)*5) - 3;
                $Stop = 5;
                }
            break;

            case 3:if ($currentPage == 1){
                $Start = 0;
                $Stop = $StopCheck; ///equals to 1
                }else{

                    
                $Start = (($currentPage -1)*5) - 2;
                $Stop = 5;
                }
            break;

            case 4:
            if ($currentPage == 1){
                $Start = 0;
                $Stop = $StopCheck; ///equals to 1
                }else{

                    
                $Start = (($currentPage -1)*5) - 1;
                $Stop = 5;
                }

            break;

        }
        include 'dbconnect.php';
        $SQL ="SELECT ID, created_at, TextA, ChatBox.UserID, userHandle FROM ChatBox 
                    INNER JOIN Users ON ChatBox.UserID = Users.userID WHERE RoomID=:roomIdentify ORDER BY ID DESC LIMIT :start ,:stop";
        $query = $Connection->prepare($SQL);
        $query->bindParam(':start', $Start, PDO::PARAM_INT);
        $query->bindParam(':stop', $Stop, PDO::PARAM_INT);
        $query->bindParam(':roomIdentify', $currentRoomChatID, PDO::PARAM_INT);
        $query->execute();
        $result = $query->fetchAll();

        foreach ($result as $row)
        {
        	array_push($result_array, $row)
        }
        $Connection = null;

        echo  json_encode($result_array);
}

public function sql_post_profilePic($UserID){
        include 'dbconnect.php';

        $querryProfilPic= $Connection->prepare("SELECT * FROM ProfilePictures WHERE userID=:tempId");
        $querryProfilPic->execute(array('tempId' => $UserID));

        $PicLinkResult = $querryProfilPic->fetch();
        $imgString="";
        if($PicLinkResult['userId'] ==  $UserID){
          $imgString ='<img  src="' .$PicLinkResult['pictureLink']  .'" alt="Smiley face" style="float:right" width="42" height="42"><br><br><br><div>';
        }else{
          $imgString = '<img  src="../ProfilePics/james.jpeg" alt="Smiley face" style="float:right" width="42" height="42"><br><br><br><div>';
        }

        return $imgString;
}

public function sql_fetch_comment(){
      include 'dbconnect.php';

      
      $currentRoomChatID = $_SESSION['currentRoomID'];

     $sqlComment ="SELECT C1.`Id`as Id,`ChatBox`.`ID` as ID,
        `ChatBox`.`created_at`,
        `ChatBox`.`TextA`,
        `ChatBox`.`UserID`,
        t2.`userHandle` as t2userHandle,
        C1.`userId` as userId,
        C1.`TextArea` as TextArea,
        C1.`Ccreated_at` as Ccreated_at,
        t3.`userHandle` as t3userHandle
        FROM `ChatBox` 
        INNER JOIN `Users` AS t2 ON `t2`.`UserID` = `ChatBox`.`userID`
        INNER JOIN `Comment` AS C1 ON `ChatBox`.`ID` = `C1`.`ChatBoxID` 
        INNER JOIN `Users` AS t3 ON `t3`.`UserID` = `C1`.`userId` 
        WHERE `RoomID`=:roomIdentify
        ORDER BY C1.`Id` DESC";
        //$sqlComment = "SELECT TextArea, ChatBoxID, Comment.userId AS userComment, Ccreated_at FROM Comment ORDER BY Id";
        $query = $Connection->prepare($sqlComment);
        $query->execute(array('roomIdentify' => $currentRoomChatID));
        $resultComment = $query->fetchAll();
        $Connection = null;

        return $resultComment;
}


public function printPagePanel($maxPageSize)
{
// $root = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    $root = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]";
    $root .= "/GlobalRoom.php?currentRoomID=" .$_SESSION['currentRoomID'];
  $page = 1;
  if( isset($_GET['page']) )
  {
    $root = str_replace('&page='.$_GET['page'], '', $root);
    $page = $_GET['page'];
  }

  $pages = pagination($page, $maxPageSize);
$stringspan ="";
  $stringspan= '<div style="text-align:center; font-weight: bold; font-size:16px; padding-bottom: 5px;">';
  for($i = 0; $i<count($pages); $i++)
  {
    if( $pages[$i] == -1  )
    {
      $stringspan .= '<span>...</span>';
     //echo '<a href="' . $root . '&page='.$maxPageSize. '">&nbsp;'. $pages[$i] .'&nbsp;</a>&nbsp;';
    }
    else
    {
      $stringspan .='<a href="' . $root . '&page='. $pages[$i] . '">&nbsp;'. $pages[$i] .'&nbsp;</a>&nbsp;';
    }
  }
 $stringspan .='</div>';  

    return  $stringspan;
}

//credit: https://gist.github.com/kottenator/9d936eb3e4e3c3e02598
public function pagination($c, $m) 
{
    $current = $c;
    $last = $m;
    $delta = 2;
    $left = $current - $delta;
    $right = $current + $delta + 1;
    $range = array();
    $rangeWithDots = array();
    $l = -1;

    for ($i = 1; $i <= $last; $i++) 
    {
        if ($i == 1 || $i == $last || $i >= $left && $i < $right) 
        {
            array_push($range, $i);
        }
    }

    for($i = 0; $i<count($range); $i++) 
    {
        if ($l != -1) 
        {
            if ($range[$i] - $l === 2) 
            {
                array_push($rangeWithDots, $l + 1);
            } 
            else if ($range[$i] - $l !== 1) 
            {
              //-1 is used to mark ...
                array_push($rangeWithDots, -1);
            }
        }
        
        array_push($rangeWithDots, $range[$i]);
        $l = $range[$i];
    }

    return $rangeWithDots;
}




		/// Display Messages
	public function displayChatMessage(){
			include "dbconnect.php";
		
			$currentRoomChatID = $_SESSION['currentRoomID'];
		 	$SQL ="SELECT created_at, TextA,userHandle FROM ChatBox INNER JOIN Users ON ChatBox.UserID = Users.userID WHERE RoomID=:roomIdentify ORDER BY ID";
			$query = $Connection->prepare($SQL);
			$query->execute(array('roomIdentify' => $currentRoomChatID));
			$count = $query->rowCount();
			 Used for debugging

			$count = $query->rowCount();
			echo $count;
			$query->setFetchMode(PDO::FETCH_ASSOC);
			$result =$query->fetchAll();
			var_dump($result);
			echo $count;
			
			

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
		*/


 ?>