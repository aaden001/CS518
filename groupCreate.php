<?php 
  ini_set('display_errors',1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);    
  session_start();
  include 'dbconnect.php';
  include 'roomClass.php';
 

   
   if(!empty($_POST['groupName']) || !empty($_POST['GroupType']))
    {
       if(isset($_POST['groupName'])&& isset($_POST['GroupType'])){
        $tempUserId = $_SESSION['userId'];

        echo $_POST['GroupType'];


        if($_POST['GroupType'] == "1")
        {
          $GroupTypeInt = 1;
        }else{
          $GroupTypeInt = 0;
        }

        echo $GroupTypeInt;
        $NewRoom = new Room();
        $roomName = stripslashes(htmlspecialchars($_POST['groupName']));
        $NewRoom->setRoomName($roomName);
        $NewRoom->setRoomTyp($GroupTypeInt);
        $NewRoom->setUserId($tempUserId);
        if($NewRoom->checkRoomDuplicate()){
            $NewRoom->CreateNewRoom(); /// creates room and add as an admistrator of that room
          require_once 'UserClass.php';///Add room creator as a user of the group
          $newusergroup = new User();
          $newusergroup->AddUserToRoom($tempUserId,$NewRoom->getRoomId());
            header("Location:Welcome.php?success=1");
        }else{
            header("Location:Welcome.php?error=12");
        }

       }
    }else{
      header("Location:Welcome.php?error=11");
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
    11. empty group Name field or groupType
    12. Room duplicate
    13. Email Not In database
    14. Not an Administrator to send invite
    15. Admin cant invite themselve
    16.
    17.
    18.
*/

?>