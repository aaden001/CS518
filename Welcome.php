<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    session_start();

    if(!isset($_SESSION['userId']) )
    {
        header("Location:index.php");
    }elseif(!isset($_SESSION['authenticationFlag'])){
         header("Location:2Fa.php");
    }else
    
    $tempUserID = $_SESSION['userId'];


function changeDefaultPicTo_github($link){
    try{
        include 'dbconnect.php';
        $link = trim($link);
        $sqlquerry = $Connection->prepare("INSERT INTO ProfilePictures(userId,pictureLink) VALUES(:tempAdminID,:tempLinkAddress) ON DUPLICATE KEY UPDATE userId=:tempUser");
        $sqlquerry->execute(array('tempAdminID' => $_SESSION['userId'],'tempLinkAddress' =>$link, 'tempUser' => $_SESSION['userId'] ));
        return $sqlquerry;
    }catch(Exception $e){
          echo 'error occoured...............................................................error occoured333'   .$e->getMessage();
    }
 
}

if(isset($_SESSION['avatarLink'])){
    try{
             if(changeDefaultPicTo_github($_SESSION['avatarLink'])){
            echo "Avatar from get gub transfered..............................................Avatar from get gub transfered";
        }else{
            echo 'error occoured...............................................................error occoured';
        }
    }catch(Exception $e){
          echo 'error occoured...............................................................error occoured222'   .$e->getMessage();
    }
   
}

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" type="text/css" href="stylewelcome.css">
   
    <title>Get Together </title>

    <!-- Bootstrap CSS CDN -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
    <!-- Our Custom CSS -->
<!--     <link rel="stylesheet" href="style2.css">
     -->    <!-- Scrollbar Custom CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.min.css">

    <!-- Font Awesome JS -->
    <script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js" integrity="sha384-kW+oWsYx3YpxvjtZjFXqazFpA7UP/MbiY4jvs+RWZo2+N94PFZ36T6TFkc9O3qoB" crossorigin="anonymous"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"></script>

     

 
</head>

<body>

    <div class="wrapper">
      <nav id="sidebar">
            <div class="sidebar-header">
                <h3 style="color: orange; font-family: tahoma; font-size: 25px;">Welcome 
                    <span>
                        <?php echo $_SESSION['userName'];?>
                            
                        </span>
                </h3>
        
            </div>
        
            <!-- <ul class="list-unstyled components"> -->
            <ul class="list-unstyled CTAs" >
              <p></p>
              <li>
              <a href="Welcome.php">Home</a>
              </li>
              <li>
              <a href="notify.php">Notification</a>
              </li>
              <li>
                  <a href="search.php">Search</a>
              </li>
              
                <?php 

              if($_SESSION['userId'] == 6){
                include_once 'roomClass.php';
                $newRoomObj = new Room();
                echo '<li>
                <a href="#roomSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Rooms</a>
                <ul class="collapse list-unstyled" id="roomSubmenu">';
                 require 'dbconnect.php';
                $tempId = $_SESSION['userId'];
                ///used the Admin(user) Id to display the users list of rooms to them
                $query = $Connection->prepare("SELECT RoomsID, Name FROM Administrators INNER JOIN Rooms ON Administrators.RoomsID = Rooms.ID WHERE UserID=:tempUserId");
                $query->execute(array('tempUserId'=> $tempId));
                while( $result = $query->fetch()){


                echo '<li class="row"><a href="GlobalRoom.php?currentRoomID=' .$result['RoomsID'] .'&page=1' .'"  class="col-8" style="margin-left: 7%">' .$result['Name'] .'Room'.'</a>';

                  if($newRoomObj->check_room_status($result['RoomsID'] ) ==1){
                 echo '<i id="' .$result['RoomsID'] .'" class="fa fa-archive col-3" style="font-size:36px; color:black;"></i></li>'; 
                  }else{
                  echo '<i id="' .$result['RoomsID'] .'" class="fa fa-archive col-3" style="font-size:36px; color:red;"></i></li>'; 
                  }
              
                }
                $Connection = null;
                echo '</ul></li>';

            }else{  
                echo '<li>
                <a href="#roomSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Rooms</a>
                <ul class="collapse list-unstyled" id="roomSubmenu">
                <a href="#JoinSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Joined Room</a>
                <ul class="collapse list-unstyled" id="JoinSubmenu">';
               
                require 'dbconnect.php';
                $tempId = $_SESSION['userId'];
                ///used the user Id to display the users list of rooms to them
                $query = $Connection->prepare("SELECT RoomsID, Name FROM UserGroups INNER JOIN Rooms ON UserGroups.RoomsID = Rooms.ID WHERE UserID=:tempUserId");
                $query->execute(array('tempUserId'=> $tempId));
                while( $result = $query->fetch()){
                echo '<li><a href="GlobalRoom.php?currentRoomID=' .$result['RoomsID'] .'&page=1'.'">' .$result['Name'] .'Room'.'</a></li>'; 
                }
                $Connection = null;

                echo '</ul><a href="#ownSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Own Room</a>
                <ul class="collapse list-unstyled" id="ownSubmenu">';
                require 'dbconnect.php';
                $tempId = $_SESSION['userId'];
                ///used the Admin(user) Id to display the users list of rooms to them
                $query = $Connection->prepare("SELECT RoomsID, Name FROM Administrators INNER JOIN Rooms ON Administrators.RoomsID = Rooms.ID WHERE UserID=:tempUserId");
                $query->execute(array('tempUserId'=> $tempId));
                while( $result = $query->fetch()){
          echo '<li class="row"><a href="GlobalRoom.php?currentRoomID=' .$result['RoomsID'] .'&page=1' .'"  class="col-8" style="margin-left: 7%">' .$result['Name'] .'Room'.'</a></li>'; 
/*<i id="' .$result['RoomsID'] .'" class="fa fa-archive col-3" style="font-size:36px; color:black;"></i>*/

                }               
                $Connection = null;

               echo '</ul></ul></li>';
              }
              echo '<li> <a href="upload.php">Upload Picture</a></li>';
                         
              ?>
              <li>
              <a href='profile.php?userId=<?php echo $_SESSION['userId'] ?>'>View My Profile</a>
              </li>
              
        </nav>
        <!-- Page Content  -->
        <div id="content">

            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="container-fluid">

                    <button type="button" id="sidebarCollapse" class="btn btn-info">
                        <i class="fas fa-align-left"></i>
                        <span>More Information</span>
                    </button>
                    <button class="btn btn-dark d-inline-block d-lg-none ml-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <i class="fas fa-align-justify"></i>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="nav navbar-nav ml-auto">
                            <li class="nav-item active">
                                <button type="button" id="creatGroup" class="btn btn-primary">Create New Group</button>
                            
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>

                <div class="dialogForm" id="dialogDiv">
                    <form action="groupCreate.php" method="POST">
                    <label for="groupName">Create New Group Name</label>
                    <input type="text" name="groupName" maxlength="50"><br>
                    <span>
                    Public:<input type="radio" name="GroupType" value="0">
                    Private:<input type="radio" name="GroupType" value="1">
                    </span><br>
                    <button  type="submit" class="btn btn-success" style="margin-top: 4px">Create Group</button>
                    </form>
                </div>
    <!--     /// Decore -->
   
                <?php 
               echo "All Public Rooms links <br>";

                require 'dbconnect.php';
                // $tempId = $_SESSION['userId']; 0 stands for public group
                $query = $Connection->prepare("SELECT * FROM Rooms WHERE grpTyp=0");
                $query->execute();
                while( $result = $query->fetch()){
                 echo '<a href="GlobalRoom.php?currentRoomID=' .$result['ID'] .'&page=1'.'">' .$result['Name'] .' Room'.'</a>'; 
                    echo "<br>";
                }
                echo '<div class="line"></div>';
                
                $Connection = null;
                ?>
            </div>
     
     

     <!-- jQuery CDN - Slim version (=without AJAX) -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <!-- Popper.JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
    <!-- jQuery Custom Scroller CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
    <script type="text/javascript" src="toggle.js"></script>
    <script type="text/javascript" src="groupCreate.js"></script>
    <!-- For dialog box -->
    <script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
    <script src="https://code.jquery.com/ui/1.11.1/jquery-ui.min.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.11.1/themes/smoothness/jquery-ui.css" />

    
    

         

</body>

</html> 
