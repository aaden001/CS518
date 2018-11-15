<?php 
    ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);

	session_start();
	include 'ChatClass.php';
	if(isset($_POST['messages'])){
		include 'dbconnect.php';
		///Querry for redirect and room Name 
		$roomName;
		$tempUserCRID =$_POST['roomId'];

		$querrystatement = "SELECT Name FROM Rooms WHERE ID=:roomID";
		$roomNamequerry=$Connection->prepare($querrystatement);
		$roomNamequerry->execute(array('roomID' => $tempUserCRID));
		$roomNameData = $roomNamequerry->fetch();
		$roomName = $roomNameData['Name'];
		$Header= "Location:";
		$endFormat = "GlobalRoom.php?currentRoomID=" .$tempUserCRID .'&page=1';
		$Header = $Header .$endFormat;
		$Connection =null;		
		///End of Querry  for redirect and room Name

		$_SESSION['ChatText'] = stripslashes(htmlspecialchars($_POST['messages']));
		$tempUserID = $_POST['userId'];
	
		$tempChtxt = $_SESSION['ChatText']; 

		$chatMsg = new Chat();
		$chatMsg->setUserId($tempUserID);
		$chatMsg->setRoomId($tempUserCRID);
		$chatMsg->setText($tempChtxt);

		
		if($chatMsg->matchCheck($chatMsg->getUserId(),$chatMsg->getRoomId()) == true){
			if ($chatMsg->insertMessegeDB()){
				$success = "success";
				echo $success;
				/*echo $chatMsg->getUserId();
				echo $chatMsg->getRoomId();
				echo $chatMsg->getText();*/
			}else{
				echo "error occurred in querry";
			}
			
			/*echo $chatMsg->insertMessegeDB();*/
		/*	header($Header);*/
		}else{
			echo "You are not in the " .$RoomName;
		/*	header($Header);*/
		}
	}

 ?>