<?php
     ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    session_start();
    $_SESSION['currentRoomID'] = $_GET['currentRoomID'];
    $_SESSION['currentPage']   = $_GET['page'];
    echo $_SESSION['currentPage'] ;
   
    echo $_SESSION['userId'];
   if(!isset($_SESSION['userId']))
    {
        header("Location:index.php");
    }else

    $tempUserID = $_SESSION['userId'];
 ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" type="text/css" href="stylewelcome.css">
    <title>Get Together </title>

<!--   Bootstrap CSS CDN-->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
<!-- Our Custom CSS-->
   <link rel="stylesheet" href="style2.css">
<!--    Scrollbar Custom CSS-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.min.css">
<!--    Font Awesome JS-->
   <!-- <script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js" integrity="sha384-kW+oWsYx3YpxvjtZjFXqazFpA7UP/MbiY4jvs+RWZo2+N94PFZ36T6TFkc9O3qoB" crossorigin="anonymous"></script>
   <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"></script> -->
<!-- Thumps Up thump down -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
   
<style>
  @media (min-width: 1200px) {
    .post{
        max-width: 100%;
    }

}

#timestamp{
  color: red;
  background-color:blue;
}
.posts-wrapper {
  width: 70%;
  margin: 20px auto;
  border: 1px solid #eee;
}
.comment-wrapper {
  width: 90%;
  margin: 20px auto;
  border: 1px solid #eee;
}
.comment-div {
  width: 100%;
  margin-bottom: 0px;
  margin-right: 0px;
  margin-left: 0px;
  margin-top: 30px;
  border: 1px solid #eee;
}

.post {
  width: 90%;
  margin: 20px auto;
  padding: 10px 5px 0px 5px;

}
.post-info {
  margin: 10px auto 0px;
  padding: 5px;
}
.fa {
  font-size: 1.2em;
}
.fa-thumbs-down, .fa-thumbs-o-down {
  transform:rotateY(180deg);
}
.logged_in_user {
  padding: 10px 30px 0px;
}
i {
  color: blue;
}
    </style>
</head> 
<body>

        <!-- Sidebar  -->
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
                        <a href="#roomSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Rooms</a>
                        <ul class="collapse list-unstyled" id="roomSubmenu">
                        <a href="#JoinSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Joined Room</a>
                        <ul class="collapse list-unstyled" id="JoinSubmenu">
                            <?php 
                        require 'dbconnect.php';
                        $tempId = $_SESSION['userId'];
                        ///used the user Id to display the users list of rooms to them
                        $query = $Connection->prepare("SELECT RoomsID, Name FROM UserGroups INNER JOIN Rooms ON UserGroups.RoomsID = Rooms.ID WHERE UserID=:tempUserId");
                        $query->execute(array('tempUserId'=> $tempId));
                while( $result = $query->fetch()){
                    echo '<li><a href="GlobalRoom.php?currentRoomID=' .$result['RoomsID'] .'&page=1'.'">' .$result['Name'] .'Room'.'</a></li>'; 
                }
                    $Connection = null;

                             ?>
                        </ul>

                        <a href="#ownSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Own Room</a>
                        <ul class="collapse list-unstyled" id="ownSubmenu">
                        <?php 
                        require 'dbconnect.php';
                        $tempId = $_SESSION['userId'];
                        ///used the Admin(user) Id to display the users list of rooms to them
                        $query = $Connection->prepare("SELECT RoomsID, Name FROM Administrators INNER JOIN Rooms ON Administrators.RoomsID = Rooms.ID WHERE UserID=:tempUserId");
                        $query->execute(array('tempUserId'=> $tempId));
                while( $result = $query->fetch()){
                    echo '<li><a href="GlobalRoom.php?currentRoomID=' .$result['RoomsID'] .'&page=1' .'">' .$result['Name'] .'Room'.'</a></li>'; 
                }
                    $Connection = null;

                             ?>
                        </ul>
                        </ul>
                    </li>
                    <li>
                        <a href="profile.php">View My Profile</a>
                    </li>
                    <?php 
                        require 'dbconnect.php';
                        $tempId = $_SESSION['userId'];
                        $query = $Connection->prepare("SELECT * FROM Administrators WHERE UserID=:tempUserId AND RoomsID=:tempRoomID");
                        $query->execute(array('tempUserId'=> $tempId,'tempRoomID' => $_SESSION['currentRoomID']));
                        $result = $query->fetch();
                if($query->rowCount() > 0){
                    echo '<li><a href="sendInvitation.php?currentRoomID=' .$result['RoomsID'] .'">' .'Invite' .'</a></li>'; 
                }
                    $Connection = null;

                             ?>
            </ul>
        </nav>

        <!-- Page Content  -->
        <div id="content" style="position: fixed;">

            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="container-fluid">

                    <button type="button" id="sidebarCollapse" class="btn btn-info">
                        <i class="fas fa-align-left"></i>
                        <span>More Information</span>
                    </button>
                    <button class="btn btn-dark d-inline-block d-lg-none ml-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <i class="fas fa-align-justify"></i>
                    </button>
                </div>
            </nav>
            
            <div class="line"></div>
         
            <div id="container" >
              
       		</div>   <!-- End of Container -->

    </div><!-- End ofPage Content  -->
    <!-- jQuery CDN - Slim version (=without AJAX) -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>

    <!-- Popper.JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>

    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>

    <!-- jQuery Custom Scroller CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
     <script type="text/javascript" src="toggle.js"></script>
    <script type="text/javascript" src="jquery.js"></script>
   <script type="text/javascript" src="load.js"></script>
  

</body>

</html> 