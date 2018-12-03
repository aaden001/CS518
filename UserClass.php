<?php 
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
	session_start();
class User{
	private $userId, $userFullname, $userEmail, $userHandle, $userPassword;
	
	public function setUserId($infoUserId){
		$this->userId = $infoUserId;
	}
	public function setUserFullname($inforUserFullname){
		$this->userFullname = $inforUserFullname;
	}
	public function setUserEmail($inforUserEmail){
		$this->userEmail = $inforUserEmail;
	}
	public function setUserHandle($inforUserHandle){
		$this->userHandle = $inforUserHandle;
	}
	public function setUserPassword($inforUserPasswd){
		$this->userPassword = $inforUserPasswd;			
	}	
	
	public function getUserId(){
		 return $this->userId;
	}
	public function getUserFullname(){
		return $this->userFullname;
	}
	public function getUserEmail(){
		return $this->userEmail;
	}
	public function getUserHandle(){
		return $this->userHandle;
	}
	public function getUserPassword(){
		return $this->userPassword;
	}
	public function checkEmailHandle()
	{	include 'dbconnect.php';

		$Sql =$Connection->prepare("SELECT userEmail FROM Users WHERE userEmail=:tempUserMail");
		$query =$Connection->prepare("SELECT userHandle FROM Users WHERE userHandle=:tempHandle");
		$Sql->execute(array('tempUserMail' => $this->getUserEmail()));
		$query->execute(array('tempHandle' =>$this->getUserHandle()));
		if($Sql->rowCount() == 0 && $query->rowCount() == 0)
		{
			return true;
		}else{
			if(isset($_SESSION['access_token'])){
				if($Sql->rowCount() > 0 && $query->rowCount() > 0)
				{
				header("Location:signUp.php?error=10&username=".$this->getUserFullname() ."&useremail=" .$this->getUserEmail() ."&userhandle=" .$this->getUserHandle());
				}elseif($Sql->rowCount() > 0){
				header("Location:signUp.php?error=8&username=".$this->getUserFullname() ."&useremail=" .$this->getUserEmail() ."&userhandle=" .$this->getUserHandle());
				}else{
				header("Location:signUp.php?error=9&username=".$this->getUserFullname() ."&useremail=" .$this->getUserEmail() ."&userhandle=" .$this->getUserHandle());
				}
			}else{
				if($Sql->rowCount() > 0 && $query->rowCount() > 0)
				{
				header("Location:signUp.php?error=10");
				}elseif($Sql->rowCount() > 0){
				header("Location:signUp.php?error=8");
				}else{
				header("Location:signUp.php?error=9");
				}
			}
			

			return false;
		}

		$Connection = null;
	}
	public function SignUpUser(){

			try{
			include "dbconnect.php";
			$Sql = $Connection->prepare("INSERT INTO Users(userFullName,userEmail,userHandle,userPassword) VALUES (:tempFullName,:tempUserMail,:tempHandle,:tempPasswd)");
			$Sql->execute(array('tempFullName' => $this->getUserFullname(),'tempUserMail' => $this->getUserEmail(), 'tempHandle' => $this->getUserHandle(),'tempPasswd' => $this->getUserPassword()));

			///Add user to the global chat room instantly
			/* By checking a matching user name and password a getting the Id 
			Use the Id to insert the user into the global chat room
			*/
			$sql = "SELECT * FROM Users WHERE userEmail=:userMail AND userPassword=:password";
			/// Execute a prepared statement with an array of insert values (named parameters)
			$query = $Connection->prepare($sql);
			$query->execute(array('userMail' =>$this->getUserEmail(),'password' => $this->getUserPassword()));
			$result = $query->fetch();
			$this->setUserId($result['userId']);
			$room = 1;
			$this->AddUserToRoom($this->getUserId(),$room);

			/*$queryG = $Connection->prepare("INSERT INTO UserGroups(UserID,RoomsID) VALUES (:tempUserID,:temGlobalRoom)");
			$queryG->execute(array('tempUserID' => $this->getUserId(), 'temGlobalRoom' => $room));*/

			$Connection = null;
			/*
			echo "Sign Up Successfull";
			header("Refresh:5; url=index.php",true, 303);*/
			}catch(PDOException $e){
			echo $e->getMessage();
			}
		
	}
	public function AddUserToRoom($userId, $roomID){
		include 'dbconnect.php';
		$queryG = $Connection->prepare("INSERT INTO UserGroups(UserID,RoomsID) VALUES (:tempUserID,:temGlobalRoom)");
		$queryG->execute(array('tempUserID' => $userId, 'temGlobalRoom' => $roomID));

		$Connection = null;
	}
	public function GetUserIdFromEmail($email){
		include 'dbconnect.php';

		$query = $Connection->prepare("SELECT userId FROM Users WHERE userEmail=:tempEmail");
		$query->execute(array('tempEmail' => $email));
		$result = $query->fetch();

		return $result['userId'];
	}
	public function RemoveUserFromRoom($userId, $roomID){
		include 'dbconnect.php';
		$queryG = $Connection->prepare("DELETE FROM UserGroups WHERE UserID=:tempUser AND RoomsID=:tempRoom");
		$queryG->execute(array('tempUser' => $userId, 'tempRoom' => $roomID));

		$Connection = null;
		return $queryG;
	}
	public function AddUserAsAdminToRoom($userId, $roomID){
		include 'dbconnect.php';
		$queryG = $Connection->prepare("INSERT INTO Administrators(UserID,RoomsID) VALUES (:tempUserID,:temGlobalRoom)");
		$queryG->execute(array('tempUserID' => $userId, 'temGlobalRoom' => $roomID));

		$Connection = null;
		return $queryG;
	}
	public function CheckUserInRoom($inviteeID,$roomId){
			include 'dbconnect.php';
			
			$querry = $Connection->prepare("SELECT UserID FROM UserGroups WHERE UserID=:tempUserID AND RoomsID=:tempRoomId");
			$querry->execute(array('tempUserID' => $inviteeID,'tempRoomId' => $roomId));
			$count = $querry->rowCount();
			if($count == 0){
				return false;
			}else{
				return true;
			}

	}
	public function loginUser(){
	///require "dbconnect.php";
		try{
			include "dbconnect.php";
			///dbcolumn
			$sql = "SELECT * FROM Users WHERE userEmail=:userMail AND userPassword=:password";
			
			/// Execute a prepared statement with an array of insert values (named parameters)
			$query = $Connection->prepare($sql);
	
			$query->execute(array('userMail' =>$this->getUserEmail(),'password' => $this->getUserPassword()));
			if($query->rowCount() == 0)
			{
				header("Location:index.php?error=1");
				return false;
			}else{
				while($userData =$query->fetch()){
					$this->setUserId($userData['userId']);
					$this->setUserFullname($userData['userFullName']);
					$this->setUserEmail($userData['userEmail']);
					$this->setUserHandle($userData['userHandle']);
					$this->setUserPassword($userData['userPassword']);
				
									
					}
					return true;
				}				
			}catch(PDOException $e)
			{
			echo "This Error Occured: " .$e->getMessage();
			}	
		}
	}
 ?>
